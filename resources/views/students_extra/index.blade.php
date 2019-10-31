@extends('layouts.app')
 
@section('content')

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
                                            <input id="search_name" name="search_stu_name" type="text" placeholder="Nama" class="form-control input-md" value="{{ (!empty(request()->query('search_stu_name'))) ? request()->query('search_stu_name') : null }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label text-center" for="search_level"><b>Level : </b></label>  
                                        <div class="col-md-4">
                                            <select class="form-control input-md" name="search_level" id="search_level">
                                                <option value="" selected disabled>Please Choose</option>
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
                                            <a href="{{ route('student_extra.index') . '?' . Request::query('limit') }}" class="btn btn-warning"><i class="fas fa-undo"></i> Reset</a>
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
                        <a class="btn btn-success" href="{{ route('student_extra.create') }}"><i class="fas fa-plus"></i> Create New Student</a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Table Data Limiter --}}
                    <div class="table_data_limit" style="margin-bottom: 10px;">
                        <form id="set_limit" method="get">
                            View: 
                            <select id="limit" name="limit" onchange="window.location.href='{{ route('student_extra.index') . '?' . http_build_query(Request::except(['limit','page'])) }}&limit='+$(this).val()">
                                <option {{ ($limit_per_page == 1) ? 'selected' : null }}>1</option>
                                <option {{ ($limit_per_page == 3) ? 'selected' : null }}>3</option>
                                <option {{ ($limit_per_page == 5) ? 'selected' : null }}>5</option>
                                <option {{ ($limit_per_page == 10) ? 'selected' : null }}>10</option>
                                <option {{ ($limit_per_page == 20) ? 'selected' : null }}>20</option>
                                <option value="-1" {{ ($limit_per_page == -1) ? 'selected' : null }}>All</option>
                            </select>
                        </form>
                    </div>
                    
                    {{-- Table Section --}}
                    <div class="table_section">
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Current Level</th>
                                <th>Current Class</th>
                                <th>Status</th>
                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td class="item_name">{{ $student->stu_name }}</td>
                                <td>{{ $student->class->level->level_name }}</td>
                                <td>{{ $student->class->class_name }}</td>
                                <td>{{ $student->getStatus() }}</td>
                                <td>
                                    <form class="delete_item" action="{{ route('student_extra.destroy',$student->id) }}" method="POST">
                    
                                        {{-- <a class="btn btn-primary btn_show_data" href="{{ route('student_extra.show',$student->id) }}" data-stuid="{{ $student->id }}"><i class="fas fa-eye"></i> Show</a> --}}
                                        <button type="button" class="btn btn-primary btn_show_data" data-stuid="{{ $student->id }}" data-toggle="modal" data-target="#myModal"><i class="fas fa-eye"></i> Show</button>
                        
                                        <a class="btn btn-warning" href="{{ route('student_extra.edit',$student->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                    
                                        @csrf
                                        @method('DELETE')
                        
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    
                        {!! $students->appends(request()->query())->links() !!}
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
        $(".delete_item").on('submit', function(e){

            var index = $('.delete_item').index(this);
            var item_name = $(".item_name:eq("+index+")").text();
            
            return confirm('Are you sure you want to delete "'+ item_name +'"?');

        });

        // AJAX LOAD CONTENT
        var token = "{{ csrf_token() }}";

        $('.btn_show_data').on('click', function(){

            var ajax = $.ajax({
                method: "POST",
                url: "{{ route('student_extra.ajax_show') }}",
                data: { 
                    "_token": token,
                    "stu_id": $(this).data('stuid')
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

        });
    });
</script>

@endsection