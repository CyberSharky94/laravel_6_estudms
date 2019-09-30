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
                        <a class="btn btn-success" href="{{ route('role.create') }}"><i class="fas fa-plus"></i> Create New Role</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td class="item_name">{{ $role->role_name }}</td>
                            <td>{{ $role->role_level }}</td>
                            <td>{{ $role->getStatus() }}</td>
                            <td>
                                <form class="delete_item" action="{{ route('role.destroy',$role->id) }}" method="POST">
                
                                    <a class="btn btn-primary" href="{{ route('role.show',$role->id) }}"><i class="fas fa-eye"></i> Show</a>
                    
                                    <a class="btn btn-warning" href="{{ route('role.edit',$role->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
                
                                    @csrf
                                    @method('DELETE')
                    
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                
                    {!! $roles->links() !!}
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
    });
</script>

@endsection