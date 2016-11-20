@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$playlist->description}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('playlists.public')}}</label>
                        <div class="col-md-6">
                            <p>{{$playlist->public}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('playlists.user')}}</label>
                        <div class="col-md-6">
                            <p>{{$playlist->user}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection