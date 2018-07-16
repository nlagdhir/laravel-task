<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Film;
use App\Genre;
use App\Comment;
use Validator;
use View;

class ApiController extends Controller
{
    /**
    * Store film 
    *
    */
    public function storeFilm(Request $request)
    {
    	$slug = str_slug($request->get('name'), '_');
    	$request->request->add(['slug' => $slug]);
    	$rules = [
            'name' => 'required|unique:films|max:191',
            'slug' => 'required',
            'description' => 'required',
            'release_date' => 'required',
            'rating' => 'required|integer|between:1,5',
            'ticket_price' => 'required|numeric|between:0,999999.99',
            'country' => 'required|max:191',
            'genre.*' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
        	'genre.*.required' => 'This field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        $request->validate($rules);

        $film = new Film;
        $film->name = $request->get('name');
        $film->slug = $request->get('slug');
        $film->description = $request->get('description');
        $film->release_date = $request->get('release_date');
        $film->rating = $request->get('rating');
        $film->ticket_price = $request->get('ticket_price');
        $film->country = $request->get('country');
        if ($request->file('photo') && $request->file('photo')->isValid()) {
			$requestedImage = $request->file('photo');
            $extension = $requestedImage->getClientOriginalExtension();
            $filename = md5(time() . str_random(12)) . '.' . $extension;
            $requestedImage->storeAs('/', $filename);
            $film->photo = $filename;
        }
		if($film->save()){
			foreach ($request->get('genre') as $genreName) {
				$genre = new Genre;
				$genre->name = $genreName;
				$genre->film_id = $film->id;
				$genre->save();
			}
			return response()->json(['status' => 1, 'message' => 'Film Created!']);
		}else{
			return response()->json(['status' => 0, 'message' => 'Film not created!'], 422);
		}
        
    }
}
