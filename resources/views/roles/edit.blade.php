@extends('layouts.app_container')

@section('main_content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="form-horizontal" action="{{ route('role.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')

    <fieldset>

    <!-- Text input-->
    <div class="form-group">
    <label class="col-md-4 control-label" for="role_name">Role Name:</label>  
    <div class="col-md-4">
    <input id="role_name" name="role_name" type="text" placeholder="Role Name" class="form-control input-md" value="{{ $role->role_name }}" required="">
        
    </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="role_level">Role Level</label>
    <div class="col-md-4">
        <select id="role_level" name="role_level" class="form-control" required>
            <option value="" disabled>Please Choose</option>
            <option {{ ($role->role_level === 1) ? 'selected' : null }}>1</option>
            <option {{ ($role->role_level === 2) ? 'selected' : null }}>2</option>
            <option {{ ($role->role_level === 3) ? 'selected' : null }}>3</option>
            <option {{ ($role->role_level === 4) ? 'selected' : null }}>4</option>
            <option {{ ($role->role_level === 5) ? 'selected' : null }}>5</option>
        </select>
    </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="status">Status</label>
    <div class="col-md-4">
        <select id="status" name="status" class="form-control" required>
            <option value="1" {{ ($role->status === 1) ? 'selected' : null }}>Active</option>
            <option value="0" {{ ($role->status === 0) ? 'selected' : null }}>Inactive</option>
        </select>
    </div>
    </div>

    <!-- Button (Double) -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="btn_submit"></label>
    <div class="col-md-8">
        <button id="btn_submit" name="btn_submit" class="btn btn-success">Submit</button>
        <button type="button" id="btn_cancel" name="btn_cancel" class="btn btn-danger" onclick="window.location.href='{{ route($return_route) }}'">Cancel</button>
    </div>
    </div>

    </fieldset>
</form>

@endsection