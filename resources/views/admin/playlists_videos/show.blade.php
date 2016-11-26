@extends('layouts.app')

@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('main.playlistsVideo')}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('playlistsVideos.playlist')}}</label>
                        <div class="col-md-6">
                            <p>{{$playlist_video->playlist}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('playlistsVideos.video')}}</label>
                        <div class="col-md-6">
                            <p>{{$playlist_video->video}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('playlists.sync')}}</label>
                        <div class="col-md-6">
                            <button id="sync" data-url="/admin/playlists_videos/{{$playlist_video->id}}" type="button" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> {{trans('main.sync')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/youtube/playlist_video.js') }}"></script>
    <script src="{{ asset('js/youtube/auth.js') }}"></script>
    <script src='https://apis.google.com/js/api.js'></script>
@endsection