<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //
    protected $fillable = [
        'title', 'link', 'tags'
    ];
    
    public function user() {
        return $this->belongsTo('App\User');
    }
}
