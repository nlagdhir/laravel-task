<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Film;

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
            view('films.load', ['films' => $films])->render();  
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:films|max:191',
            'description' => 'required',
            'release_date' => 'required',
            'rating' => 'required|integer|between:1,5',
            'ticket_price' => 'required|numeric|between:0,999999.99',
            'country' => 'required|max:191',
            'genre.*' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $request->validate($rules);
        return $request->all();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
