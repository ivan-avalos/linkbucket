<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
	$links = DB::table('links')->where('user_id', Auth::id())->simplePaginate(15);
        return view('home', ['links'=>$links]);
    }
    public function edit($id)
    {
	$link = DB::table('links')->where('id', $id)->get();
	if(sizeof($link) == 0) return '<h1>Link not found</h1>';
	if($link[0]->user_id != Auth::id()) return '<h1>Unauthorized</h1>';
	return view('edit', ['link'=>$link[0]]);
    }
}
