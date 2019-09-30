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

<form class="form-horizontal" action="{{ route('role.store') }}" method="POST">
    @csrf
    <fieldset>

    <!-- Text input-->
    <div class="form-group">
    <label class="col-md-4 control-label" for="role_name">Role Name:</label>  
    <div class="col-md-4">
    <input id="role_name" name="role_name" type="text" placeholder="Role Name" class="form-control input-md" required="">
        
    </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="role_level">Role Level</label>
    <div class="col-md-4">
        <select id="role_level" name="role_level" class="form-control" required>
            <option value="" selected disabled>Please Choose</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="status">Status</label>
    <div class="col-md-4">
        <select id="status" name="status" class="form-control" required>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
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