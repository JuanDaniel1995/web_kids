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
                <div class="panel-heading">{{trans('children.new')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('admin.children.store')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">{{trans('children.username')}}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                            <label for="birthdate" class="col-md-4 control-label">{{trans('children.birthdate')}}</label>

                            <div class="col-md-6">
                                <input id="birthdate" type="text" class="form-control" name="birthdate" value="{{ old('birthdate') }}">

                                @if ($errors->has('birthdate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{trans('main.password')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">{{trans('main.confirm_password')}}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('enabled_search') ? ' has-error' : '' }}">
                            <label for="enabled_search" class="col-md-4 control-label">{{trans('children.enabled_search')}}</label>
                            <div class="col-md-6">
                                <select id="enabled_search" name="enabled_search" class="selectpicker">
                                    <option value="E">{{trans('children.search.true')}}</option>
                                    <option value="D">{{trans('children.search.false')}}</option>
                                </select>

                                @if ($errors->has('enabled_search'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('enabled_search') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('restricted_mode') ? ' has-error' : '' }}">
                            <label for="restricted_mode" class="col-md-4 control-label">{{trans('children.restricted_mode')}}</label>
                            <div class="col-md-6">
                                <select id="restricted_mode" name="restricted_mode" class="selectpicker">
                                    <option value="Y">{{trans('children.restricted.true')}}</option>
                                    <option value="N">{{trans('children.restricted.false')}}</option>
                                </select>

                                @if ($errors->has('restricted_mode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('restricted_mode') }}</strong>
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