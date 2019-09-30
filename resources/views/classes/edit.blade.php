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

<form class="form-horizontal" action="{{ route('class.update', $class->id) }}" method="POST">
    @csrf
    @method('PUT')
    <fieldset>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="class_name">Class Name:</label>  
        <div class="col-md-4">
        <input id="class_name" name="class_name" type="text" placeholder="Class Name" class="form-control input-md" value="{{ $class->class_name }}" required="">
            
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="level_id">Level:</label>
        <div class="col-md-4">
            <select id="level_id" name="level_id" class="form-control" required>
                <option value="" disabled>Choose Level</option>
                @foreach ($level_list as $level_id => $level_name)
                    <option value="{{ $level_id }}" {{ ($class->level->level_id === $level_id) ? 'selected' : null }} >{{ $level_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="status">Status:</label>
        <div class="col-md-4">
            <select id="status" name="status" class="form-control" required>
                <option value="1" {{ ($class->status === 1) ? 'selected' : null }}>Active</option>
                <option value="0" {{ ($class->status === 0) ? 'selected' : null }}>Inactive</option>
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