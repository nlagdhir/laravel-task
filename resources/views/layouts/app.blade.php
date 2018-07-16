<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('film.create') }}">{{ __('Add Film') }}</a>
                        </li>
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {

            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

            jQuery('#release_date').datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                autoclose: true,
            });

            // add more genre 
            var addButton = jQuery('.add_button');
            var wrapper = jQuery('.genre_wrapper');
            var fieldHTML = '<div><input type="text" class="form-control width90" name="genre[]"><a href="javascript:void(0);" class="remove_button genre-control"><img src="{{ asset("images/remove-icon.png") }}"/></a></div>';
            var x = 1;

            //Once add button is clicked
            jQuery(addButton).click(function() {
                x++;
                jQuery(wrapper).append(fieldHTML);
            });

            //Once remove button is clicked
            jQuery(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                jQuery(this).parent('div').remove();
                x--;
            });

            jQuery('body').on('click', '.pagination a', function(e) {
                e.preventDefault();

                jQuery('#load a').css('color', '#dfecf6');
                jQuery('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="{{ asset("images/loader.gif") }}" />');

                var url = $(this).attr('href');
                getFilms(url);
                window.history.pushState("", "", url);
            });

        });

        // prepare the form when the DOM is ready 
        $(document).ready(function() {
            var options = {
                beforeSubmit: showRequest,
                success: showResponse,
                error: showErrors
            };

            // bind to the form's submit event 
            $('#AddFilmForm').submit(function() {
                $(this).ajaxSubmit(options);
                return false;
            });
        });

        function getFilms(url) {
            $.ajax({
                url: url,
                success: function(data) {
                    $('.films').html(data);
                },
                error: function() {
                    alert('Films could not be loaded.');
                },
            });
        }

        // pre-submit callback 
        function showRequest(formData, jqForm, options) {
            $("#AddFilmForm .submitForm").text("loading");
            $("#AddFilmForm .submitForm").attr('disabled', 'disabled');
            return true;
        }

        // post-submit callback 
        function showResponse(responseText, statusText, xhr, $form) {
            if (responseText.status == 1) {
                alert(responseText.message);
                document.location.href = "{{ route('films') }}"
            }
            $("#AddFilmForm .submitForm").removeAttr('disabled');
            $("#AddFilmForm .submitForm").text("Create Film");
        }

        function showErrors(errors) {
            $("#AddFilmForm .is-invalid").removeClass("is-invalid");
            $('#AddFilmForm .invalid-feedback').html('');
            $("#AddFilmForm .submitForm").removeAttr('disabled');
            $("#AddFilmForm .submitForm").text("Create Film");
            if (errors.responseJSON.errors) {
                for (var i in errors.responseJSON.errors) {
                    if (i.indexOf("genre.") >= 0) {
                        $("#AddFilmForm .genre_section input").addClass('is-invalid');
                        $("#AddFilmForm .genre_section .invalid-feedback").html(errors.responseJSON.errors[i]);
                    }
                    $("#AddFilmForm ." + i + "_section input").addClass('is-invalid');
                    $("#AddFilmForm ." + i + "_section textarea").addClass('is-invalid');
                    $("#AddFilmForm ." + i + "_section .invalid-feedback").removeClass('hide');
                    $("#AddFilmForm ." + i + "_section .invalid-feedback").html(errors.responseJSON.errors[i]);
                }
            }
        }
    </script>
</body>

</html>