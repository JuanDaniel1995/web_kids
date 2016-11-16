@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('main.edit')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('videos.update', $video->id)}}">
                        {{ csrf_field() }}
                        <input type='hidden' name='_method' value='PUT'>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">{{trans('videos.description')}}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ $errors->has('description') ? old('description') : $video->description }}">

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label for="url" class="col-md-4 control-label">{{trans('videos.url')}}</label>

                            <div class="col-md-6">
                                <input id="url" type="text" class="form-control" name="url" value="{{ $errors->has('url') ? old('url') : $video->url }}">

                                @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-4 control-label">{{trans('videos.category')}}</label>

                            <div class="col-md-6">
                                <select id="category_id" name="category_id" class="selectpicker">
                                    @foreach($categories as $category)
                                        <option {{$category->name == $video->category ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
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