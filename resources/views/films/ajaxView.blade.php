@if($film->Total() > 0)
	<div class="row">
		<div class="col-md-4 post-img">
			<img class="img-responsive1" src="{{ asset('uploads/films/') }}{{ $film->photo }}" alt="UIkit 3 - A brief Introduction and Comparison with Bootstrap">
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
			@if($film->genres->count() > 0)
				@foreach($film->genres as $genre)
					<li>{{ $genre->name }}</li>
				@endforeach
			@endif
			</ul>
		</div>
	</div>
@else
	<p>Films not found</p>
@endif

