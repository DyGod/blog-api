<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public $timestamps = true;
    protected $fillable = [
        'title', 'slug', 'content', 'category', 'thumbnail'
    ];


    public function next(){
        return Post::where('id', '>', $this->id)->orderBy('id', 'ASC')->first();
    }


    public function prev(){
        return Post::where('id', '<', $this->id)->orderBy('id', 'DESC')->first();
    }


}
