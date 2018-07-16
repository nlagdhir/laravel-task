<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Film;
use View;

class FilmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $films = Film::latest()->paginate(1);

        if ($request->ajax()) {
            return View::make('films.load', ['films' => $films])->render();  
        }

        return view('films.index', compact('films'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('films.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $film = Film::where('slug',$slug)
                ->with('genres')
                ->with(['comments'=>function($comments){
                    $comments->latest();
                }])->first();
        return view('films.show',compact('film'));
    }

    /**
    * Post comment to a film
    */
    public function postComment(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:191',
            'comment' => 'required|min:3',
        ];

        $request->validate($rules);
        
        $comment = new Comment;
        $comment->name = $request->get('name');
        $comment->comment = $request->get('comment');
        $comment->film_id = $id;
        $comment->user_id = auth()->user()->id;
        if($comment->save()){
            flash('Comment added!')->success();
        }else{
            flash('Comment could not added!')->error();
        }
        return redirect()->back();
    }
}
