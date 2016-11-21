@extends('layouts.app')

@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading center-text">{{trans('main.categories')}}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{trans('categories.name')}}</th>
                    <th>{{trans('categories.description')}}</th>
                    <th>{{trans('categories.minimum_age')}}</th>
                    <th>{{trans('main.edit')}}</th>
                    <th>{{trans('main.delete')}}</th>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td><a href="{{route('admin.categories.show', $category->id)}}">{{$category->name}}</a></td>
                        <td>{{$category->description}}</td>
                        <td>{{$category->minimum_age}}</td>
                        <td><a href="{{route('admin.categories.edit', $category->id)}}"><span class='glyphicon glyphicon-pencil'></a></td>
                        <td><a href="javascript:deleteCategory('{{ $category->id }}');"><span class='glyphicon glyphicon-trash'></a></td>
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