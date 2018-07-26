<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;
use App\Link;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$user = User::find(Auth::id());
    	$links = $user->links()->orderBy('id', 'desc')->simplePaginate(15);
    	foreach($links as $link) $link->tags = explode(" ", $link->tags);
    	
    	return view('home', ['links'=>$links]);
    }
    
    public function search(Request $request)
    {
        // Validate
        if(($validator = Validator::make($request->all(), [
            'search'=>'required' ]))->fails())
            return redirect('home')->withErrors($validator, 'search');
        
        $query = $request->input('search');
        
        $user = User::find(Auth::id());
        $links = $user->links()->orderBy('id', 'desc')
            ->where('title', 'like', '%'.$query.'%')
            ->orWhere('link', 'like', '%'.$query.'%')
            ->orWhere('tags', 'like', '%'.$query.'%')
            ->simplePaginate(15);
        foreach($links as $link) $link->tags = explode(" ", $link->tags); 
        
    	return view('home', ['links'=>$links, 'no_add'=>true, 'title'=>'Search: '.$query, 'back'=>true]);
    }
    
    public function edit($id)
    {
    	$user = User::find(Auth::id());
    	$link = @$user->links()->where('id', $id)->get()[0];
    	if($link) return view('edit', ['link'=>$link]);
    	else return '<h1>Link not found</h1>';
    }

    public function tags($tag){
        $user = User::find(Auth::id());
    	$links = $user->links()->orderBy('id', 'desc')->get();
    	$filtered = [];
    	foreach($links as $link) {
    	    $link->tags = explode(" ", $link->tags);
    	    if(in_array($tag, $link->tags))
    	       array_push($filtered, $link);
    	}
    	return view('home', ['links'=>$filtered, 'no_add'=>true, 'pagination'=>false,
    	'title'=>'Tag: '.$tag, 'back'=>true]);
    }	
}
