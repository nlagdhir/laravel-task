@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Films</div>

                <div class="card-body" id="view-film">
                    @if (count($films) > 0)
                    <section class="films">
                        @include('films.load')
                    </section>
                	@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
