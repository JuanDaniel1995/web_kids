@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading center-text">{{trans('main.videos')}}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{trans('videos.description')}}</th>
                    <th>{{trans('videos.url')}}</th>
                    <th>{{trans('videos.category')}}</th>
                    <th>{{trans('main.edit')}}</th>
                    <th>{{trans('main.delete')}}</th>
                </thead>
                <tbody>
                @foreach($videos as $video)
                    <tr>
                        <td><a href="{{route('videos.show', $video->id)}}">{{$video->description}}</a></td>
                        <td>{{$video->url}}</td>
                        <td>{{$video->category}}</td>
                        <td><a href="{{route('videos.edit', $video->id)}}"><span class='glyphicon glyphicon-pencil'></a></td>
                        <td><a href="javascript:deleteUser('{{ $video->id }}');"><span class='glyphicon glyphicon-trash'></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection