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

    /*
    * return user of perticular comment
    */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
