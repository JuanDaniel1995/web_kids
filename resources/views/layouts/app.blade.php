<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Web kids</title>

    <!-- Fonts -->
    @section('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel='stylesheet' type='text/css' href="{{ asset('css/styles.css') }}" />
    @show
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            @if (!Auth::guest())
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{trans('main.users')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('admin.users.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.users')}}</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{trans('main.children')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('admin.children.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.children')}}</a></li>
                            <li><a href="{{route('admin.children_playlist.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.playlist')}}</a></li>
                            <li><a href="{{route('admin.children_playlist.create')}}"><i class="fa fa-btn fa-user"></i> {{trans('playlists.assign')}}</a></li>
                            <li><a href="{{route('admin.children.create')}}"><i class="fa fa-btn fa-plus"></i> {{trans('main.create')}}</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{trans('main.categories')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('admin.categories.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.categories')}}</a></li>
                            <li><a href="{{route('admin.categories.create')}}"><i class="fa fa-btn fa-plus"></i> {{trans('main.create')}}</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{trans('main.tags')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('admin.tags.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.tags')}}</a></li>
                            <li><a href="{{route('admin.tags.create')}}"><i class="fa fa-btn fa-plus"></i> {{trans('main.create')}}</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{trans('main.videos')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('admin.videos.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.videos')}}</a></li>
                            <li><a href="{{route('admin.tags_videos.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.tags')}}</a></li>
                            <li><a href="{{route('admin.tags_videos.create')}}"><i class="fa fa-btn fa-user"></i> {{trans('tags.assign')}}</a></li>
                            <li><a href="{{route('admin.videos.create')}}"><i class="fa fa-btn fa-plus"></i> {{trans('main.create')}}</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{trans('main.playlist')}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{route('admin.playlists.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.playlist')}}</a></li>
                            <li><a href="{{route('admin.playlists_videos.index')}}"><i class="fa fa-btn fa-user"></i> {{trans('main.videos')}}</a></li>
                            <li><a href="{{route('admin.playlists_videos.create')}}"><i class="fa fa-btn fa-user"></i> {{trans('videos.assign')}}</a></li>
                            <li><a href="{{route('admin.playlists.create')}}"><i class="fa fa-btn fa-plus"></i> {{trans('main.create')}}</a></li>
                        </ul>
                    </li>
                </ul>
            @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/admin/login') }}">{{trans('main.login')}}</a></li>
                        <li><a href="{{ url('/admin/register') }}">{{trans('main.register')}}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/admin/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{trans('main.logout')}}</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    
    @section('javascripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    @show
</body>
</html>
