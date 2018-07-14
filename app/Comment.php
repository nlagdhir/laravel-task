<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /*
	* return film of perticular comment
	*/
    public function film()
    {
    	return $this->belongsTo(Film::class);
    }
}
