@extends('layouts.app')

@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('main.edit')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('admin.playlists_videos.update', $playlist_video->id)}}">
                        {{ csrf_field() }}
                        <input type='hidden' name='_method' value='PUT'>

                        <div class="form-group{{ $errors->has('video_id') ? ' has-error' : '' }}">
                            <label for="video_id" class="col-md-4 control-label">{{trans('playlistsVideos.video')}}</label>
                            <div class="col-md-6">
                                <select id="video_id" name="video_id" class="selectpicker">
                                    @foreach($videos as $video)
                                        <option {{$playlist_video->video_id == $video->id ? 'selected' : ''}} value="{{$video->id}}">{{$video->description}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('video_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('video_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('playlist_id') ? ' has-error' : '' }}">
                            <label for="playlist_id" class="col-md-4 control-label">{{trans('playlistsVideos.playlist')}}</label>
                            <div class="col-md-6">
                                <select id="playlist_id" name="playlist_id" class="selectpicker">
                                    @foreach($playlists as $playlist)
                                        <option {{$playlist_video->playlist_id == $playlist->id ? 'selected' : ''}} value="{{$playlist->id}}">{{$playlist->description}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('playlist_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('playlist_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> {{trans('main.edit')}}
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

@section('javascripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
@endsection