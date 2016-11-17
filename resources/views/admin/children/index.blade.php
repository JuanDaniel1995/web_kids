@extends('layouts.app')

@section('content')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading center-text">{{trans('main.children')}}</div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>{{trans('children.username')}}</th>
                    <th>{{trans('children.birthdate')}}</th>
                    <th>{{trans('children.enabled_search')}}</th>
                    <th>{{trans('children.restricted_mode')}}</th>
                    <th>{{trans('main.edit')}}</th>
                    <th>{{trans('main.delete')}}</th>
                </thead>
                <tbody>
                @foreach($children as $child)
                    <tr>
                        <td><a href="{{route('admin.children.show', $child->id)}}">{{$child->username}}</a></td>
                        <td>{{$child->birthdate}}</td>
                        <td>{{$child->enabled_search}}</td>
                        <td>{{$child->restricted_mode}}</td>
                        <td><a href="{{route('admin.children.edit', $child->id)}}"><span class='glyphicon glyphicon-pencil'></a></td>
                        <td><a href="javascript:deleteChild('{{ $child->id }}');"><span class='glyphicon glyphicon-trash'></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection