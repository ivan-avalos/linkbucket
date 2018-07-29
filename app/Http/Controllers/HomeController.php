<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Lang;

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
    	$links = $user->links()->orderBy('id', 'desc')->paginate(15);
    	
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
            ->paginate(15);
            
        $_title = Lang::get('home.title.search', ['query'=>$query]);
    	return view('home', ['links'=>$links->appends($request->all()), 'no_add'=>true, 'title'=>$_title, 'back'=>true]);
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
    	$links = $user->links()->withAnyTag($tag)->orderBy('id', 'desc')->paginate(15);
    	
    	$_title = Lang::get('home.title.tags', ['tag'=>$tag]);
        return view('home', ['links'=>$links, 'no_add'=>true,
    	'title'=>$_title, 'back'=>true]);
    }	
    
    // Site info
    public function site_about() { return view('site/about'); }
    public function site_features() { return view('site/features'); }
    public function site_oss() { return view('site/open-source'); }
    public function site_terms() { return view('site/terms'); }    
    public function site_privacy() { return view('site/privacy'); }
    public function site_api() { return view('site/api'); }
}
