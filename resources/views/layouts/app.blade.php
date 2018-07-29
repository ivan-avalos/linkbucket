<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Linkbucket') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/lovely-tag.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lovely-tag.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Linkbucket') }}
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
                                
                                    <!-- Import from Pocket -->
                                    <button type="button" class="dropdown-item" data-toggle="modal" data-target="#import">
                                        {{ __('app.import.label') }}
                                    </button>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
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
        
        <!-- Import modal -->
        <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="importLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="importLabel">{{ __('app.import.modal.header') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        {!! __('app.import.modal.body') !!}
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <i class="fas fa-ban"></i> {{ __('app.import.modal.footer.cancel') }}</button>
                        <a class="btn btn-danger" href="/import">
                            <i class="fas fa-download"></i> {{ __('app.import.modal.footer.import') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <main class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    
    <footer>
        <div class="container py-5">
            <p class="mb-0 text-uppercase font-weight-bold small text-justify">
                <a href="/site/about" class="text-primary pr-3">{{ __('app.footer.about') }}</a>
                <!--<a href="https://pixelfed.social/site/help" class="text-primary pr-3">Support</a>-->
                <a href="/site/open-source" class="text-primary pr-3">{{ __('app.footer.open-source') }}</a>
                <a href="/site/terms" class="text-primary pr-3"> {{ __('app.footer.terms') }} </a>
                <a href="/site/privacy" class="text-primary pr-3"> {{ __('app.footer.privacy') }} </a>
                <a href="/site/platform" class="text-primary pr-3">{{ __('app.footer.api') }}</a>
                <!--<a href="#" class="text-primary pr-3">Directory</a>-->
                <!--<a href="#" class="text-primary pr-3">Profiles</a>-->
                <!--<a href="#" class="text-primary pr-3">Hashtags</a>-->
                <!--<a href="https://pixelfed.social/site/language" class="text-primary pr-3">Language</a>-->
                <a href="https://github.com/ivan-avalos/linkbucket" class="text-muted float-right" rel="noopener">{{ __('app.footer.powered') }}</a>
                </p>
        </div>
    </footer>
    <script type="text/javascript" >
        $('#import').modal();
    </script>
</body>
</html>
