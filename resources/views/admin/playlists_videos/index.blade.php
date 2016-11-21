@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading center-text">{{trans('main.playlistsVideo')}}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{trans('playlistsVideos.playlist')}}</th>
                    <th>{{trans('playlistsVideos.video')}}</th>
                    <th>{{trans('main.edit')}}</th>
                    <th>{{trans('main.delete')}}</th>
                </thead>
                <tbody>
                @foreach($playlists as $list)
                    <tr>
                        <td><a href="{{route('admin.playlists_videos.show', $list->id)}}">{{$list->playlist}}</a></td>
                        <td>{{$list->video}}</td>
                        <td><a href="{{route('admin.playlists_videos.edit', $list->id)}}"><span class='glyphicon glyphicon-pencil'></a></td>
                        <td><a href="javascript:deletePlaylistVideo('{{ $list->id }}');"><span class='glyphicon glyphicon-trash'></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection