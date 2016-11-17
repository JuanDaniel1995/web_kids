@extends('layouts.child')

@section('content')
<header>
    <div class="header-content">
        <div class="header-content-inner">
            <h1 id="homeHeading">{{trans('main.appSlogan')}}</h1>
            <hr>
            <p>{{trans('main.appDescription')}}</p>
            <a href="#videos" class="btn btn-primary btn-xl page-scroll">{{trans('main.seeVideos')}}</a>
        </div>
    </div>
</header>

<section class="bg-primary" id="videos">
    <div class="container">
        <div class="row">
            <h1 class="page-header text-center">{{trans('main.videos')}}</h1>
            @foreach($videos as $video)
                <div class="col-md-6 portfolio-item">
                    <h3>{{$video->description}}</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" src="{{$video->url}}"></iframe>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
