<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;
use App\Link;
use Conner\Tagging\Model\Tag;

class MainController extends Controller
{
    private function get_website_title($url) {
        $data = @file_get_contents($url);
        if($data === FALSE || $data === null) return $url;
        $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : $url;
        $title = preg_replace_callback(array("/(&#x[0-9]+;)/", "/(&#[0-9a-zA-Z]+;)/", "/(&[0-9a-zA-Z]+;)/"), function($m) { 
            return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); 
        }, $title); 
        return $title;
    }  
    
    //
    function add(Request $request) {
        // Validate
        $request->validate([
            'link' => 'required|unique:links'
        ]);
        
        $link = $request->input('link');
        $tags = $request->input('tags');
        
        // Get title from website
        $title = $this->get_website_title ($link);
        
        $dblink = new Link;
        $dblink->user_id = Auth::id();
        $dblink->title = $title;
        $dblink->link = $link;
        // rtconner tags
        $dblink->save();
        if (isset($tags)) {
            $tag = $dblink->tag(explode(' ', $tags));
            $dblink->save();
        }
        
        return Redirect::route('home');
    }
    function remove($id) {
        $user = User::find(Auth::id());
        $user->links()->findOrFail($id)->delete();
        return Redirect::route('home');
    }
    
    function update($id, Request $request) {
        $request->validate([
            'title'=>'required',
            'link'=>'required'
        ]);
        
        $title = $request->input('title');
        $link = $request->input('link');
        $tags = $request->input('tags');
    
        $user = User::find(Auth::id());
        $dblink = $user->links()->findOrFail($id);
        $dblink->title = $title;
        $dblink->link = $link;
        $dblink->save();
        $dblink->retag(explode(' ', $tags));
        $dblink->save();
        
        return Redirect::route('home');
    }
}
