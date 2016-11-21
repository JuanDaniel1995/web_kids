@extends('layouts.app')

@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading center-text">{{trans('main.tags')}}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{trans('tags.description')}}</th>
                    <th>{{trans('main.edit')}}</th>
                    <th>{{trans('main.delete')}}</th>
                </thead>
                <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td><a href="{{route('admin.tags.show', $tag->id)}}">{{$tag->description}}</a></td>
                        <td><a href="{{route('admin.tags.edit', $tag->id)}}"><span class='glyphicon glyphicon-pencil'></a></td>
                        <td><a href="javascript:deleteTag('{{ $tag->id }}');"><span class='glyphicon glyphicon-trash'></a></td>
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