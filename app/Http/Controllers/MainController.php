<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;
use App\Link;

class MainController extends Controller
{
    private function get_website_title($url) {
        $data = file_get_contents($url);
        $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : $url;
        return $title;
    }  
    
    //
    function add(Request $request) {
        $link = $request->input('link');
        $tags = $request->input('tags').' ';
        
        // Get title from website
        $title = $this->get_website_title ($link);
        
        $dblink = new Link;
        $dblink->user_id = Auth::id();
        $dblink->title = $title;
        $dblink->link = $link;
        $dblink->tags = $tags;
        $dblink->save();
        
        return Redirect::route('home');
    }
    function remove($id) {
        $user = User::find(Auth::id());
        $user->links()->where('id', $id)->delete();
        
        return Redirect::route('home');
    }
    
    function update($id, Request $request) {
        $title = $request->input('title');
        $link = $request->input('link');
        $tags = $request->input('tags');
    
        $dblink = Link::find($id);
        $dblink->title = $title;
        $dblink->link = $link;
        $dblink->tags = $tags;
        $dblink->save();
        
        return Redirect::route('home');
    }
}
