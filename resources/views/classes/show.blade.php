@extends('layouts.app_container')

@section('main_content')

<table class="table table-bordered table-sm table-striped table-hover">
    <tr>
        <th>Class Name:</th>
        <td>{{ $class->class_name }}</td>
    </tr>
    <tr>
        <th>Level:</th>
        <td>{{ $class->level->level_name }}</td>
    </tr>
    <tr>
        <th>Status:</th>
        <td>{{ $class->getStatus() }}</td>
    </tr>
    <tr>
        <th>Created At:</th>
        <td>{{ $class->changeDateTimeFormat($class->created_at) }}</td>
    </tr>
    <tr>
        <th>Updated At:</th>
        <td>{{ $class->changeDateTimeFormat($class->updated_at) }}</td>
    </tr>
</table>

@endsection