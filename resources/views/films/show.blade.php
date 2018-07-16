@extends('layouts.app') @section('content')
<div class="container">
	@include('flash::message')
    <div class="row">
        @if($film && $film->count()>0)
        <div class="col-md-4 post-img">
            <img class="img-responsive" width="300" src="{{ asset('storage/') }}/{{ $film->photo }}" alt="{{ $film->name }}">
        </div>
        <div class="col-md-8">
            <h3>{{ $film->name }}</h3>
            <p class="text-justify">{{ $film->description }}</p>
            <p>Release Date : {{ $film->release_date }}</p>
            <p>Rating : {{ $film->rating }}</p>
            <p>Ticket Price : ${{ $film->ticket_price }}</p>
            <p>Country : {{ $film->country }}</p>
            <p>Genre : </p>
            <ul>
                @if($film->genres->count() > 0) @foreach($film->genres as $genre)
                <li>{{ $genre->name }}</li>
                @endforeach @endif
            </ul>
        </div>
    </div>
	
	<div class="col-md-8">
        <h2 id="comments">Comments: </h2>
        
        @auth
        <div class="newPost">
        	<form method="post" action="{{ route('film.comment',$film->id) }}">
        		@csrf
        		<div class="form-group row">
                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name" required>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                    	<textarea id="comment" class="form-control {{ $errors->has('comment') ? ' is-invalid' : '' }}" required="required" name="comment" placeholder="Comment">{{ old('comment') }}</textarea>
                       
						 @if ($errors->has('comment'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            Post
                        </button>
                    </div>
                </div>
        	</form>
            <hr>
        </div>
        @endauth
        @if($film->comments->count() > 0)
        	@foreach($film->comments as $comment)
        	<div class="row">
			    <div class="col-sm-1">
			        <div class="thumbnail">
			            <img class="img-responsive user-photo" width="50" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
			        </div>
			    </div>
			    
			    <div class="col-sm-5">
			        <div class="panel panel-default">
			            <div class="panel-heading">
			                <strong>{{ $comment->user->name }}</strong> <span class="text-muted">commented {{ $comment->created_at->diffForHumans() }}</span>
			            </div>
			            <div class="panel-body">
			                {{ $comment->comment }}
			            </div>
			        </div>
			    </div>
			</div>
			<hr>
        	@endforeach
        @else
        <div class="row">
        	<div class="col-md-12">
        		No comments found
        	</div>
        </div>
        @endif
       
        </div>
    </div>
</div>
    @else

    <div class="col-md-12">
        <p class="text-center">Film not found</p>
    </div>

    @endif
</div>
</div>

@endsection