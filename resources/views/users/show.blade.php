@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$user->name}}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('users.email')}}</label>
                        <div class="col-md-6">
                            <p>{{$user->email}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('users.role')}}</label>
                        <div class="col-md-6">
                            <p>{{$user->role}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection