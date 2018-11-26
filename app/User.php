<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Conner\Tagging\Taggable;

class User extends Authenticatable
{
    use Notifiable;
    use Taggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function links() {
        return $this->hasMany('App\Link');
    }
    
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
    
    private static function get_website_title($url) {
        $data = @file_get_contents($url);
        if($data === FALSE || $data === null) return $url;
        $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : $url;
        return $title;
    }
    
    /**
     * Database CRUD operations.
     */
    
    /* Retrieve links */
    public function _retrieve($query = NULL, $paginate = false, $tag = NULL, $id = NULL) {
        $links = $this->links()->orderBy('id', 'desc');
        
        // Retrieve single
        if ($id) {
            $link = $links->findOrFail($id);
            return $link;
        }
        if($tag) $links = $links->withAnyTag($tag);
        if ($query) $links->where('title', 'like', "%{$query}%")->get();
        if ($paginate) $links = $links->paginate(15);
        else $links = $links->get();
        
        	return $links;
    }
    
    /* Insert link */
    public function _insert(Request $request) {
        // Validate
        $request->validate([
            'link' => 'required|unique:links'
        ]);
        
        $link = $request->input('link');
        
        // Get title from website
        if($request->has('title'))
            $title = $request->input('title');
        else $title = $this->get_website_title ($link);
        
        $dblink = new Link;
        $dblink->user_id = $this->id;
        $dblink->title = $title;
        $dblink->link = $link;
        // rtconner tags
        if($request->has('tags')) {
            $tags = $request->input('tags');
            $dblink->save();
            $dblink->tag(explode(' ', $tags));
            $this->tag(explode(' ', $tags));
        }
        $dblink->save();
        
        return Link::find($dblink->id);
    }
    
    /* Update link */
    public function _update($id, Request $request) {
        $request->validate([
            'title'=>'required',
            'link'=>'required'
        ]);
        
        $title = $request->input('title');
        $link = $request->input('link');
        $tags = $request->input('tags');
    
        $dblink = $this->links()->findOrFail($id);
        $dblink->title = $title;
        $dblink->link = $link;
        $dblink->save();
        $dblink->retag(explode(' ', $tags));
        $this->tag(explode(' ', $tags));
        $dblink->save();
        
        return $this->_retrieve($query = NULL, $paginate = false, $tag = NULL, $id = $id);
    }
    
    /* Remove link */
    public function _remove($id) {
        $this->links()->findOrFail($id)->delete();
    }
    
    /** 
     * Tagging library operations.
     */
     
    // Retrieve tags
    public function retrieveTags () {
         $tags = [];
         $linkTags = Link::existingTags();
         $userTags = $this->tagNames();
         
         foreach ($linkTags as $tag) {
             if (in_array($tag->name, $userTags)) {
                 $tags[] = $tag->name;
             }
         }
         return $tags;
    }
}