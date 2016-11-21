@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$playlist_video->playlist}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('playlists_videos.video')}}</label>
                        <div class="col-md-6">
                            <p>{{$playlist_video->video}}</p>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection