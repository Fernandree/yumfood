<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['id','name','logo','created_at','updated_at'];
    
    public function tags()
    {
        
        return $this->morphToMany('App\Tag', 'taggable');
    }
}
