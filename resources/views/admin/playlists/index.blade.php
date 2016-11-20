@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading center-text">{{trans('main.playlist')}}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{trans('playlists.user')}}</th>
                    <th>{{trans('playlists.description')}}</th>
                    <th>{{trans('playlists.public')}}</th>
                    <th>{{trans('main.edit')}}</th>
                    <th>{{trans('main.delete')}}</th>
                </thead>
                <tbody>
                @foreach($playlists as $list)
                    <tr>
                        <td><a href="{{route('admin.playlists.show', $list->id)}}">{{$list->user}}</a></td>
                        <td>{{$list->description}}</td>
                        <td>{{$list->public}}</td>
                        <td><a href="{{route('admin.playlists.edit', $list->id)}}"><span class='glyphicon glyphicon-pencil'></a></td>
                        <td><a href="javascript:deletePlaylist('{{ $list->id }}');"><span class='glyphicon glyphicon-trash'></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection