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
        $user = Auth::guard('api')->user();
        $links = $user->_retrieve();
        $cleanLinks = $user->_retrieve();
        
        // Clean useless fields
        $tags = [];
        foreach($links as $link) $tags[] = $link->tagNames();
        foreach(range(0, count($links)-1) as $i) $cleanLinks[$i]->Tags = $tags[$i];
        
        return response()->json($cleanLinks, 200);
    }
    
    public function single($id) {
        $user = Auth::guard('api')->user();
        $link = $user->_retrieve($query = NULL, $paginate = false, $tag = NULL, $id = $id);
        $cleanLink = $user->_retrieve($query = NULL, $paginate = false, $tag = NULL, $id = $id);
        $cleanLink->Tags = $link->tagNames();
        
        return response()->json($cleanLink, 200);
    }
    
    //
    function add(Request $request) {
        $user = Auth::guard('api')->user();
        return response()->json($user->_insert($request), 200);
    }
    
    function update($id, Request $request) {
        $user = Auth::guard('api')->user();
        return response()->json($user->_update($id, $request), 200);
    }
    
    function remove($id) {
        $user = Auth::guard('api')->user();
        $link = $user->_retrieve($query = NULL, $paginate = false, $tag = NULL, $id = $id);
        $user->_remove($id);
        return response()->json($link, 200);
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
