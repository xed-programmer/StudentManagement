@extends('layouts.admin')

@section('header')
    {{ __('Add Schedule') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Schedule Information</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <form method="POST" action="{{ route('admin.schedule.add') }}">
            @csrf
            <div class="card-body">
                <!-- Student Code / RFID -->
                <div class="form-group">
                    <x-label for="school_year" :value="__('Student Code')" />

                    <x-input id="school_year" class="form-control" type="text" name="school_year"
                        :value="old('school_year')" required />
                </div>

                <!-- Name -->
                <div class="form-group">
                    <x-label for="subject" :value="__('Subject')" />

                    <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required />
                    <select name="subject" id="subject" class="form-control">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject }}" @if (old('subject') == $subject)
                                selected
                        @endif>{{ $subject }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Email Address -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <x-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                        placeholder="Email" required />
                </div>

                <!-- Contact number -->
                <div class="form-group">
                    <x-label for="phone" :value="__('Guardian\'s Phone Number')" />

                    <x-input id="phone" class="form-control" type="tel" name="phone" :value="old('phone')" required />
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
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
