@extends('layouts.admin')

@section('header')
    {{ __('Edit Professor') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Professor Information</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <form method="POST" action="{{ route('admin.professor.update', $professor) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <!-- Units -->
                <div class="form-group col-3">
                    <x-label for="units" :value="__('Units')" />

                    <x-input id="units" class="form-control" type="number" name="units" :value="$professor->units" required
                        autofocus />
                </div>

                <!-- Name -->
                <div class="form-group">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" class="form-control" type="text" name="name" :value="$professor->user->name"
                        required />
                </div>

                <!-- Email Address -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <x-input id="email" class="form-control" type="email" name="email" :value="$professor->user->email"
                        placeholder="Email" required />
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
