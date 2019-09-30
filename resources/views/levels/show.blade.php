@extends('layouts.app_container')

@section('main_content')

<table class="table table-bordered table-sm table-striped table-hover">
    <tr>
        <th>Level Name:</th>
        <td>{{ $level->level_name }}</td>
    </tr>
    <tr>
        <th>Level Number:</th>
        <td>{{ $level->level_number }}</td>
    </tr>
    <tr>
        <th>Status:</th>
        <td>{{ $level->getStatus() }}</td>
    </tr>
    <tr>
        <th>Created At:</th>
        <td>{{ $level->changeDateTimeFormat($level->created_at) }}</td>
    </tr>
    <tr>
        <th>Updated At:</th>
        <td>{{ $level->changeDateTimeFormat($level->updated_at) }}</td>
    </tr>
</table>

@endsection