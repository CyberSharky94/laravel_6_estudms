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

<form class="form-horizontal" action="{{ route('level.update', $level->id) }}" method="POST">
    @csrf
    @method('PUT')

    <fieldset>

    <!-- Text input-->
    <div class="form-group">
    <label class="col-md-4 control-label" for="level_name">Level Name:</label>  
    <div class="col-md-4">
    <input id="level_name" name="level_name" type="text" placeholder="Level Name" class="form-control input-md" value="{{ $level->level_name }}" required="">
        
    </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="level_number">Level Number</label>
    <div class="col-md-4">
        <select id="level_number" name="level_number" class="form-control" required>
            <option value="" disabled>Please Choose</option>
            <option {{ ($level->level_number === 1) ? 'selected' : null }}>1</option>
            <option {{ ($level->level_number === 2) ? 'selected' : null }}>2</option>
            <option {{ ($level->level_number === 3) ? 'selected' : null }}>3</option>
            <option {{ ($level->level_number === 4) ? 'selected' : null }}>4</option>
            <option {{ ($level->level_number === 5) ? 'selected' : null }}>5</option>
            <option {{ ($level->level_number === 6) ? 'selected' : null }}>6</option>
        </select>
    </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
    <label class="col-md-4 control-label" for="status">Status</label>
    <div class="col-md-4">
        <select id="status" name="status" class="form-control" required>
            <option value="" disabled>Please Choose</option>
            <option value="1" {{ ($level->status === 1) ? 'selected' : null }}>Active</option>
            <option value="0" {{ ($level->status === 0) ? 'selected' : null }}>Inactive</option>
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