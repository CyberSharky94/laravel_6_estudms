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

    
    <!-- File Button & Image Placeholder --> 
    <div class="form-group">
        <label class="col-md-4 control-label" for="student_image">Add Student Picture:</label>
        <div class="col-md-4">
            <img id="student_image_placeholder" src="" alt="" style="border-radius: 10px; margin-bottom: 10px;"><br>
            <button class="btn btn-primary" type="button" onclick="$('#student_image_btn').trigger('click');">Add Image</button>
            <input style="display: none;" id="student_image_btn" name="student_image" class="input-file" type="file" accept=".jpg, .jpeg, .png" onchange="preview_selected_image(this)">
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

{{-- MODAL --}}
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
    
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">View Student</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
    
            <!-- Modal body -->
            <div class="modal-body" id="modal_content">
                {{-- Modal Content Goes Here --}}
            </div>
    
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
    
        </div>
    </div>
</div>

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

        // $('form').on('submit', function(e){
        //     // e.preventDefault();
        // });
    });

    // Preview Image after Choosing File
    function preview_selected_image(image) {
        if(image.files && image.files[0])
        {
            console.log(image.files[0]);
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#student_image_placeholder").attr('src', e.target.result).width(200).height(200);
            }
            reader.readAsDataURL(image.files[0]);
        } else {
            $("#student_image_placeholder").attr('src', null);
        }
    }
</script>

@endsection