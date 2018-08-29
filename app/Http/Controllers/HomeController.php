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
    	$tags = Link::existingTags();
    	
    	return view('home', ['links'=>$links, 'tags'=>$tags]);
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
            ->paginate(15)
            ->appends($request->all());
            
        $_title = Lang::get('home.title.search', ['query'=>$query]);
    	return view('home', ['links'=>$links, 'no_add'=>true, 'title'=>$_title, 'back'=>true]);
    }
    
    public function edit($id)
    {
        $link = Link::findOrFail($id);
    	return view('edit', ['link'=>$link]);
    }

    public function tags($tag){
    	$user = User::find(Auth::id());
    	$links = $user->links()->withAnyTag($tag)->orderBy('id', 'desc')->paginate(15);
    	
    	$_title = Lang::get('home.title.tags', ['tag'=>$tag]);
        return view('home', ['links'=>$links, 'no_add'=>true, 'title'=>$_title, 'back'=>true]);
    }
}
