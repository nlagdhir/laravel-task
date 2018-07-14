@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Film</div>

                <div class="row justify-content-center">
                <div class="card-body">
                    <form method="POST" id="AddFilmForm" action="{{ route('storeFilm') }}" enctype="multipart/form-data"  aria-label="{{ __('Register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6 name_section">
                                <input id="name" type="text" class="form-control" name="name" value=""  autofocus>
                                <span class="invalid-feedback hide" role="alert">
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6 description_section">
                                <textarea id="description" class="form-control" name="description" ></textarea>
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="release_date" class="col-md-4 col-form-label text-md-right">Release Date</label>

                            <div class="col-md-6 release_date_section">
                                <input id="release_date" type="text" class="form-control" name="release_date" >
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rating" class="col-md-4 col-form-label text-md-right">Rating</label>

                            <div class="col-md-6 rating_section">
                                <select  id="rating" name="rating" class="form-control">
                                    @for($i=1;$i<=5;$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="ticket_price" class="col-md-4 col-form-label text-md-right">Ticket Price</label>

                            <div class="col-md-6 ticket_price_section">
                                <input id="ticket_price" type="text" class="form-control" name="ticket_price" value="">
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

                            <div class="col-md-6 country_section">
                                <input id="country" type="text" class="form-control" name="country" value="">
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group row genre_section">
                            <label for="genre" class="col-md-4 col-form-label text-md-right">Genre</label>
                            <div class="col-md-6 genre_wrapper">
                                <div>
                                    <input type="text" class="form-control width90" name="genre[]">
                                    <a href="javascript:void(0);" class="add_button genre-control" title="Add genre"><img src="{{ asset("images/add-icon.png") }}"/></a>
                                </div>
                            </div>
                            <span class="invalid-feedback" role="alert">
                            </span>
                        </div>


                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>

                            <div class="col-md-6 photo_section">
                                <input id="photo" type="file" class="form-control" name="photo" >
                                <span class="invalid-feedback" role="alert">
                                </span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary submitForm">
                                    {{ __('Create Film') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
