<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    function add(Request $request) {
        $title = $request->input('title');
	$link = $request->input('link');
	$tags = $request->input('tags');
	DB::table('links')->insert(
	    ['user_id' => Auth::id(), 'link'=>$link, 'title'=>$title, 'tags'=>$tags]
	);
        return Redirect::route('home');
    }
    function remove($id) {
        DB::table('links')->where('user_id', Auth::id())->where('id', $id)->delete();
	return Redirect::route('home');
    }
    function update($id, Request $request) {
        $title = $request->input('title');
	$link = $request->input('link');
	$tags = $request->input('tags');
        $results = DB::table('links')->where('id', $id)->get();
	if(sizeof($results) <= 0) return 'Link not found';
	if($results[0]->user_id != Auth::id()) return '<h1>Unauthorized</h1>';
	DB::table('links')->where('id', $id)->update(['title'=>$title,
	'link'=>$link, 'tags'=>$tags]);
	return Redirect::route('home');
    }
}
