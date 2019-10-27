@extends('layouts.app')
 
@section('content')

<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{!! $message !!}</p>
            </div>
            @endif

            {{-- Search Section --}}
            <div id="search_section" style="margin-bottom: 10px;">
                <div class="card">
                    <div class="card-header" id="search_box_header" data-toggle="collapse" data-target="#search_box" aria-expanded="true" aria-controls="search_box">
                        <b><i class="fas fa-search"></i> SEARCH</b>
                    </div>
                
                    <div id="search_box" class="collapse" aria-labelledby="search_box_header" data-parent="#search_section">
                        <div class="card-body">
                            <form class="form-horizontal" method="GET">
                                <fieldset>
                                    <!-- Nama -->
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label text-center" for="search_name"><b>Name : </b></label>  
                                        <div class="col-md-4">
                                            <input id="search_stu_name" name="search_stu_name" type="text" placeholder="Nama" class="form-control input-md" value="{{ (!empty(request()->query('search_stu_name'))) ? request()->query('search_stu_name') : null }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label text-center" for="search_level"><b>Level : </b></label>  
                                        <div class="col-md-4">
                                            <select class="form-control input-md" name="search_level" id="search_level">
                                                <option id="search_level" value="" selected disabled>Please Choose</option>
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}" {{ ($level->id == Request::query('search_level')) ? 'selected' : null }}>{{ $level->level_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{-- SEARCH BUTTON --}}
                                        <div class="col-md-12 text-center">
                                            <button id="" name="" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                                            <a href="{{ route('student.index_datatable') }}" class="btn btn-warning"><i class="fas fa-undo"></i> Reset</a>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                                        
                        </div>
                    </div>
                </div>
            </div>
            {{-- END: Search Section --}}

            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <legend>{{ $title }}</legend>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('student.create') }}"><i class="fas fa-plus"></i> Create New Student</a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- DataTable Test --}}
                    <div class="datatable">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Current Level</th>
                                <th>Current Class</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

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
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Dealing with URL Parameter
        $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

            if(results == null)
            {
                return null;
            } else {
                return results[1] || 0;    
            }
        };

        // AJAX LOAD CONTENT
        var token = "{{ csrf_token() }}";

        // DataTables
        $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("student.index_datatable") }}',
                data: function(d) {
                    d.search_stu_name = $.urlParam('search_stu_name');
                    d.search_level = $.urlParam('search_level');
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'stu_name', name: 'stu_name' },
                { data: 'level_name', name: 'level_name' },
                { data: 'class_name', name: 'class_name' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

    // AJAX Load Detail View
    function ajax_show_details(stu_id) {   
        console.log(stu_id);

        var token = "{{ csrf_token() }}";
        
        var ajax = $.ajax({
            method: "POST",
            url: "{{ route('student.ajax_show') }}",
            data: { 
                "_token": token,
                "stu_id": stu_id
            }
        });

        ajax.done(function(data) {
            console.log( "success" );
            $('#modal_content').html(data);
        });
        ajax.fail(function() {
            console.log( "error" );
        });
        ajax.always(function() {
            console.log( "complete" );
        });
    }

    // Delete Confirmation
    $("table").on('submit', '.delete_item', function(e){
        return confirm('Are you sure you want to delete the student?');
    });
</script>

@endsection