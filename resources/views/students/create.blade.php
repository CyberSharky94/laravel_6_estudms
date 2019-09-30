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

<form class="form-horizontal" action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <fieldset>

    
    <!-- File Button --> 
    <div class="form-group">
        <label class="col-md-4 control-label" for="student_image">Add Student Picture:</label>
        <div class="col-md-4">
            <input id="student_image" name="student_image" class="input-file" type="file" accept=".jpg, .jpeg, .png">
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="stu_name">Student Name:</label>  
        <div class="col-md-4">
            <input id="stu_name" name="stu_name" type="text" placeholder="Student Name" class="form-control input-md" required="">
            
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="stu_dob">Date of Birth:</label>  
        <div class="col-md-4">
            <input id="stu_dob" name="stu_dob" type="date" placeholder="Date of Birth" class="form-control input-md" required="">
            
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="stu_phone">Phone Number:</label>  
        <div class="col-md-4">
            <input id="stu_phone" name="stu_phone" type="text" placeholder="Phone Number" class="form-control input-md" required="">
            
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="level_id">Level:</label>
        <div class="col-md-4">
            <select id="level_id" name="level_id" class="form-control" required>
                <option value="" selected disabled>Choose Level</option>
                @foreach ($level_list as $level_id => $level_name)
                    <option value="{{ $level_id }}">{{ $level_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="current_class_id">Class:</label>
        <div class="col-md-4">
            <select id="current_class_id" name="current_class_id" class="form-control" required>
                <option class="current_class_id_item" value="" selected disabled>Choose Class</option>
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

{{-- JavaScript --}}
<script>
    $(document).ready(function(){
        var token = "{{ csrf_token() }}";

        $('#level_id').on('change', function(){
            var ajax = $.ajax({
                method: "POST",
                url: "{{ route('student.ajax_get_class_list') }}",
                data: { 
                    "_token": token,
                    "level_id": $(this).val()
                }
            });

            ajax.done(function(data) {
                console.log( "success" );

                $("#current_class_id").html(data);
                $(".current_class_id_item:eq(0)").prop('selected', true);
            });
            ajax.fail(function() {
                console.log( "error" );
            });
            ajax.always(function() {
                console.log( "complete" );
            });
        });
    });
</script>

@endsection