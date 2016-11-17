@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$child->username}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('children.birthdate')}}</label>
                        <div class="col-md-6">
                            <p>{{$child->birthdate}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('children.enabled_search')}}</label>
                        <div class="col-md-6">
                            <p>{{$child->enabled_search}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('children.restricted_mode')}}</label>
                        <div class="col-md-6">
                            <p>{{$child->restricted_mode}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection