<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Link;

class ApiController extends Controller
{
    
    //
    public function retrieve() {
        $links = Auth::guard('api')->user()->links()->orderBy('id', 'desc')->get();
        $cleanLinks = Auth::guard('api')->user()->links()->orderBy('id', 'desc')->get();
        $tags = [];
        foreach($links as $link) $tags[] = $link->tagNames();
        foreach(range(0, count($links)-1) as $i) $cleanLinks[$i]->taggs = $tags[$i];
            
        return response()->json($cleanLinks, 200);
    }
    
    public function single($id) {
        $link = Auth::guard('api')->user()->links()->findOrFail($id);
        $cleanLink = Auth::guard('api')->user()->links()->findOrFail($id);
        $cleanLink->taggs = $link->tagNames();
        
        return response()->json($cleanLink, 200);
    }
    
    private function get_website_title($url) {
        $data = @file_get_contents($url);
        if($data === FALSE || $data === null) return $url;
        $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : $url;
        return $title;
    }  
    
    //
    function add(Request $request) {
        // Validate
        $request->validate([
            'link' => 'required|unique:links'
        ]);
        
        $link = $request->input('link');
        
        // Get title from website
        $title = $this->get_website_title ($link);
        
        $dblink = new Link;
        $dblink->user_id = Auth::guard('api')->id();
        $dblink->title = $title;
        $dblink->link = $link;
        // rtconner tags
        if($request->has('tags')) {
            $tags = $request->input('tags');
            $dblink->save();
            $dblink->tag(explode(' ', $tags));
        }
        $dblink->save();
        
        return $this->single($dblink->id);
    }
    
    function update($id, Request $request) {
        $request->validate([
            'title'=>'required',
            'link'=>'required',
            'tags'=>'required'
        ]);
        
        $title = $request->input('title');
        $link = $request->input('link');
        $tags = $request->input('tags');
    
        $user = Auth::guard('api')->user();
        $dblink = $user->links()->findOrFail($id);
        $dblink->title = $title;
        $dblink->link = $link;
        $dblink->save();
        $dblink->retag(explode(' ', $tags));
        $dblink->save();
        
        return $this->single($dblink->id);
    }
    
    function remove($id) {
        $link = $this->single($id);
        Auth::guard('api')->user()->links()->findOrFail($id)->delete();
        return $link;
    }
    
    /**
     * Logout function for API
     * 
     * @param  Request  $request
     * @return \App\User
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
    
        if ($user) {
            $user->api_token = null;
            $user->save();
        }
    
        return response()->json(['data' => 'User logged out.'], 200);
    }
}
