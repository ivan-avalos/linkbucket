<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Conner\Tagging\Taggable;

class Link extends Model
{
    use Taggable;
    //
    protected $fillable = [
        'title', 'link', 'tags'
    ];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
