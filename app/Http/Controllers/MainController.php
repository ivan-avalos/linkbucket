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
    /**
     * This controller performs database
     * operations called from views.
     */
    
    //
    function add(Request $request) {
        $user = User::find(Auth::id());
        $user->_insert($request);
        return Redirect::route('home');
    }
    
    function remove($id) {
        $user = User::find(Auth::id());
        $user->_remove($id);
        return Redirect::route('home');
    }
    
    function update($id, Request $request) {
        $user = User::find(Auth::id());
        $user->_update($id, $request);
        return Redirect::route('home');
    }
}