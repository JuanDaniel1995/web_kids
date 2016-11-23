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
                    <form class="form-horizontal" role="form" method="POST" action="{{route('admin.playlists.update', $playlist->id)}}">
                        {{ csrf_field() }}
                        <input type='hidden' name='_method' value='PUT'>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">{{trans('playlists.description')}}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ $errors->has('description') ? old('description') : $playlist->description }}">

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('public') ? ' has-error' : '' }}">
                            <label for="public" class="col-md-4 control-label">{{trans('playlists.public')}}</label>

                            <div class="col-md-6">
                                <select id="public" name="public" class="selectpicker">
                                    <option {{$playlist->public_value == 'Y' ? 'selected' : ''}} value="Y">{{trans('playlists.status.true')}}</option>
                                    <option {{$playlist->public_value == 'N' ? 'selected' : ''}} value="N">{{trans('playlists.status.false')}}</option>
                                </select>

                                @if ($errors->has('public'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('public') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> {{trans('main.register')}}
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