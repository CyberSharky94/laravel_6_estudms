@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <legend>{{ $title }}</legend>
                    </div>
                    <div class="float-right">
                        <a class="btn btn-primary" href="{{ route($return_route) }}"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
                    </div>
                </div>

                <div class="card-body">
                    @yield('main_content')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection