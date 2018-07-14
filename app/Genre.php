<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /*
	* return film of perticular genre
	*/
    public function film()
    {
    	return $this->belongsTo(Film::class);
    }
}
