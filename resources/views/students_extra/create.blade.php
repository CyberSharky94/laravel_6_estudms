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

{!! Form::open(['url' => route('student_extra.store'), 'files' => true]) !!}

    <fieldset>
    
    <div class="form-group">
        
        <div class="col-md-4">
            {{ Form::label('student_image', 'Student\'s Picture:', ['class' => 'control-label']) }}
            <img id="student_image_placeholder" src="" alt="" style="border-radius: 10px; margin-bottom: 10px;"><br>
            <button class="btn btn-primary" type="button" onclick="$('#student_image_btn').trigger('click');">Add Image</button>
            {!! Form::file('student_image', [
                'id' => 'student_image_btn',
                'class' => "input-file",
                'accept' => ".jpg, .jpeg, .png",
                'onchange' => "preview_selected_image(this)",
                'style' => "display: none;",
            ]) !!}
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="stu_name">Student Name:</label>  
        <div class="col-md-4">
            {!! Form::text('stu_name', null, [
                'id' => "stu_name",
                'class' => 'form-control input-md',
                'placeholder' => "Student Name",
            ]) !!}            
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="stu_dob">Date of Birth:</label>  
        <div class="col-md-4">
            {!! Form::date('stu_dob', date('Y-m-d'), [
                'id' => 'stu_dob',
                'class' => 'form-control input-md',
            ]) !!}
        </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" for="stu_phone">Phone Number:</label>  
        <div class="col-md-4">
            {!! Form::text('stu_phone', null, [
                'id' => "stu_phone",
                'class' => 'form-control input-md',
            ]) !!}
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="level_id">Level:</label>
        <div class="col-md-4">
            {!! Form::select('level_id', $level_list, null, [
                'id' => "level_id",
                'class' => 'form-control input-md',
                'placeholder' => 'Choose Level',
            ]) !!}
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="current_class_id">Class:</label>
        <div class="col-md-4">
            {!! Form::select('current_class_id', [], null, [
                'id' => "current_class_id",
                'class' => 'form-control input-md',
                'placeholder' => 'Choose Class',
            ]) !!}
        </div>
    </div>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="status">Status</label>
        <div class="col-md-4">
            {!! Form::select('status', [
                1 => 'Active',
                0 => 'Inactive'
            ], null, [
                'id' => "status",
                'class' => 'form-control input-md',
                'placeholder' => 'Choose Class',
            ]) !!}
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

{!! Form::close() !!}

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
                url: "{{ route('student_extra.ajax_get_class_list') }}",
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