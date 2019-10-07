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
                                <form class="delete_item" action="{{ route('student.destroy',$student->id) }}" method="POST">
                
                                    {{-- <a class="btn btn-primary btn_show_data" href="{{ route('student.show',$student->id) }}" data-stuid="{{ $student->id }}"><i class="fas fa-eye"></i> Show</a> --}}
                                    <button type="button" class="btn btn-primary btn_show_data" data-stuid="{{ $student->id }}" data-toggle="modal" data-target="#myModal"><i class="fas fa-eye"></i> Show</button>
                    
                                    <a class="btn btn-warning" href="{{ route('student.edit',$student->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                
                                    @csrf
                                    @method('DELETE')
                    
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                
                    {!! $students->links() !!}

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
                url: "{{ route('student.ajax_show') }}",
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