<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    // Site info
    public function site_about() { return view('site/about'); }
    public function site_features() { return view('site/features'); }
    public function site_oss() { return view('site/open-source'); }
    public function site_terms() { return view('site/terms'); }    
    public function site_privacy() { return view('site/privacy'); }
    public function site_api() { return view('site/api'); }
}
