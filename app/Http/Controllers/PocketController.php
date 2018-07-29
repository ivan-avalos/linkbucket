<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Jobs\PocketJob;
use App\User;
use App\Link;

class PocketController extends Controller
{
    //
    private function get_headers_from_curl_response($response)
    {
        $headers = array();
        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0) $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        return $headers;
    } 
    
    public function import() {
        // Step 1: Obtain a platform consumer key
        $pocket_consumer_key = getenv('POCKET_CONSUMER_KEY') ?: null;
        $redirect_url = getenv('APP_URL') ?: null;
        $err = '';
        
        if($pocket_consumer_key === null) $err .= '<p>POCKET_CONSUMER_KEY not specified in .env<p>';
        if($redirect_url === null) $err .= '<p>APP_URL not specified in .env<p>';
        
        if($pocket_consumer_key !== null && $redirect_url !== null) {
            // Step 2 - Obtain a request token
            
            $pocket_consumer_key = urlencode($pocket_consumer_key);
            $redirect_url = $redirect_url;
            
            $ch = curl_init($url = "https://getpocket.com/v3/oauth/request");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "consumer_key={$pocket_consumer_key}&redirect_uri={urlencode($redirect_url)}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Accept: application/json'));
            $response = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if($status != 200) switch($status) {
                case 400: return $status.' Missing parameter(s).';
                case 403: return $status.' Invalid consumer key.';
                default:
                    if (substr($status, 0, $length = 2) == '50')
                        return $status.' Pocket server issue.';
                    else return $status.' Unknown error';
            };
            
            // Step 3 - Redirect user to Pocket to continue authorization
            $response = json_decode($response, $assoc=true);
            $request_code = $response['code'];
            $redirect_url = urlencode($redirect_url."/import2?request_code={$request_code}&consumer_key={$pocket_consumer_key}");
            return redirect("https://getpocket.com/auth/authorize?request_token={$request_code}&redirect_uri={$redirect_url}");
            
        } else return $err;
    }
    
    public function import2(Request $request) {
        // Step 4: Receive the callback from Pocket : OK
        
        // Step 5: Convert a request token into a Pocket access token
        $pocket_consumer_key = $request->input('consumer_key');
        $request_code = $request->input('request_code');        
        
        $ch = curl_init('https://getpocket.com/v3/oauth/authorize');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "consumer_key={$pocket_consumer_key}&code={$request_code}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Accept: application/json'));
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($status != 200) return $status.' Something went wrong.';
        
        // Step 6: Make authenticated requests to Pocket
        $response = json_decode($response, $assoc = true);
        $access_token = $response['access_token'];
        
        // Get bookmarks
        $ch = curl_init('https://getpocket.com/v3/get');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "consumer_key={$pocket_consumer_key}&access_token={$access_token}&detailType=complete&sort=oldest");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Accept: application/json'));
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($status != 200) return $status.' Something went wrong.';
        
        $response = json_decode($response, $assoc=true);
        
        $links = [];
        foreach(array_values($response['list']) as $link) {
            $title = null;
            $link_ = null;
            $tags = null;            
            
            // URL
            $link_ = $link['given_url'];
            // Title
            if(array_key_exists('resolved_title', $link)) 
                $title = $link['resolved_title'];
            else $title = $link_;
            // Tags
            if(array_key_exists('tags', $link)){
                $tags = array_keys($link['tags']);
                $tags = implode(' ', $tags);
            }           
            
            //$this->add($title, $link_, $tags);
            $links[] = array('user_id'=>Auth::id(), 'link'=>$link_, 'title'=>$title, 'tags'=>$tags);
            //PocketJob::dispatch($title, $link_, $tags);
        }
        PocketJob::dispatch($links);
        
        return redirect('home');
    }
}
