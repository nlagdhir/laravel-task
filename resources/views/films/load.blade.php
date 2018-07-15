<div id="load" style="position: relative;">
@foreach($films as $film)
    <div>
        <h3>
            <a href="{{ action('FilmsController@show', [$film->slug]) }}">{{$film->name }}</a>
        </h3>
    </div>
@endforeach
</div>
{{ $films->links() }}