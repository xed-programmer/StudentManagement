@extends('layouts.admin')

@push('links')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush
@section('header')
    {{ __('Update Course') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Course Information</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <form method="POST" action="{{ route('admin.course.update', $course) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <!-- Code -->
                <div class="form-group">
                    <x-label for="code" :value="__('Code')" />

                    <x-input id="code" class="form-control" type="text" name="code" :value="$course->code" required
                        autofocus />
                </div>

                <!-- Name -->
                <div class="form-group">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" class="form-control" type="text" name="name" :value="$course->name" required />
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        @if (session()->has('message'))
            $(document).ready(function() {
            $("#alert").fadeTo(3000, 500).slideUp(500, function() {
            $("#alert").slideUp(500);
            $("#alert").remove();
            });
            });
        @endif
    </script>
@endpush
