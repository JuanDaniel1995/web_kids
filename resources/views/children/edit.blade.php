@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('main.edit')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('children.update', $child->id)}}">
                        {{ csrf_field() }}
                        <input type='hidden' name='_method' value='PUT'>
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">{{trans('children.username')}}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ $errors->has('username') ? old('username') : $child->username }}">

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
                                <input id="birthdate" type="text" class="form-control" name="birthdate" value="{{ $errors->has('birthdate') ? old('birthdate') : $child->birthdate }}">

                                @if ($errors->has('birthdate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('enabled_search') ? ' has-error' : '' }}">
                            <label for="enabled_search" class="col-md-4 control-label">{{trans('children.enabled_search')}}</label>
                            <div class="col-md-6">
                                <select id="enabled_search" name="enabled_search" class="selectpicker">
                                    <option {{$child->search_value == 'E' ? 'selected' : ''}} value="E">{{trans('children.search.true')}}</option>
                                    <option {{$child->search_value == 'D' ? 'selected' : ''}} value="D">{{trans('children.search.false')}}</option>
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
                                    <option {{$child->restricted_value == 'Y' ? 'selected' : ''}} value="Y">{{trans('children.restricted.true')}}</option>
                                    <option {{$child->restricted_value == 'N' ? 'selected' : ''}} value="N">{{trans('children.restricted.false')}}</option>
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
