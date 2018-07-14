<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
	/*
	* Films has many comments
	*/
    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }

    /*
    * Film has many genre
    */
    public function genres()
    {
    	return $this->hasMany(Genre::class);
    }
}
