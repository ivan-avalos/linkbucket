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
        
        $links = $user->links()
            ->where('title', 'like', "%{$query}%")
            ->orderBy('id', 'desc')
            ->simplePaginate(15);
        
    	return view('home', ['links'=>$links->appends($request->all()), 'no_add'=>true, 'title'=>'Search: '.$query, 'back'=>true]);
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
    	$links = $user->links()->withAnyTag($tag)->orderBy('id', 'desc')->simplePaginate(15);
    	
        return view('home', ['links'=>$links, 'no_add'=>true,
    	'title'=>'Tag: '.$tag, 'back'=>true]);
    }	
}
