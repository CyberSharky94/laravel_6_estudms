@extends('layouts.app_container')

@section('main_content')

<table class="table table-bordered table-sm table-striped table-hover">
    <tr>
        <th>Role Name:</th>
        <td>{{ $role->role_name }}</td>
    </tr>
    <tr>
        <th>Role Level:</th>
        <td>{{ $role->role_level }}</td>
    </tr>
    <tr>
        <th>Status:</th>
        <td>{{ $role->getStatus() }}</td>
    </tr>
    <tr>
        <th>Created At:</th>
        <td>{{ $role->changeDateTimeFormat($role->created_at) }}</td>
    </tr>
    <tr>
        <th>Updated At:</th>
        <td>{{ $role->changeDateTimeFormat($role->updated_at) }}</td>
    </tr>
</table>

@endsection