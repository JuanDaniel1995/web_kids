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
                    <form class="form-horizontal" role="form" method="POST" action="{{route('admin.children_playlist.update', $data->id)}}">
                        {{ csrf_field() }}
                        <input type='hidden' name='_method' value='PUT'>

                        <div class="form-group{{ $errors->has('playlist_id') ? ' has-error' : '' }}">
                            <label for="playlist_id" class="col-md-4 control-label">{{trans('childrenplaylist.playlist')}}</label>
                            <div class="col-md-6">
                                <select id="playlist_id" name="playlist_id" class="selectpicker">
                                    @foreach($playlists as $playlist)
                                        <option {{$data->playlist_id == $playlist->id ? 'selected' : ''}} value="{{$playlist->id}}">{{$playlist->description}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('playlist_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('playlist_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('children_id') ? ' has-error' : '' }}">
                            <label for="children_id" class="col-md-4 control-label">{{trans('childrenplaylist.children')}}</label>
                            <div class="col-md-6">
                                <select id="children_id" name="children_id" class="selectpicker">
                                    @foreach($children as $child)
                                        <option {{$data->children_id == $child->id ? 'selected' : ''}} value="{{$child->id}}">{{$child->username}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('children_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('children_id') }}</strong>
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