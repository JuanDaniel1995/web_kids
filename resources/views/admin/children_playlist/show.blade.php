@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('main.children_playlist')}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('childrenplaylist.children')}}</label>
                        <div class="col-md-6">
                            <p>{{$data->description}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('childrenplaylist.playlist')}}</label>
                        <div class="col-md-6">
                            <p>{{$data->username}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection