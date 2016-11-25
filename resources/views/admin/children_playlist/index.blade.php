@extends('layouts.app')

@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading center-text">{{trans('main.children_playlist')}}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{trans('childrenplaylist.children')}}</th>
                    <th>{{trans('childrenplaylist.playlist')}}</th>
                    <th>{{trans('main.edit')}}</th>
                    <th>{{trans('main.delete')}}</th>
                </thead>
                <tbody>
                @foreach($data as $list)
                    <tr>
                        <td><a href="{{route('admin.children_playlist.show', $list->id)}}">{{$list->user}}</a></td>
                        <td>{{$list->username}}</td>
                        <td>{{$list->descripcion}}</td>
                        <td><a href="{{route('admin.children_playlist.edit', $list->id)}}"><span class='glyphicon glyphicon-pencil'></a></td>
                        <td><a href="javascript:deletePlaylist('{{ $list->id }}');"><span class='glyphicon glyphicon-trash'></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
@stop