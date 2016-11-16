@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$video->description}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('videos.url')}}</label>
                        <div class="col-md-6">
                            <p>{{$video->url}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('videos.category')}}</label>
                        <div class="col-md-6">
                            <p>{{$video->category}}</p>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-offset-1">
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="{{$video->url}}"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection