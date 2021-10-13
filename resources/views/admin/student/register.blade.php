@extends('layouts.admin')

@section('header')
{{ __('Add Student') }}
@endsection   
@section('content')
@if(session()->has('message'))
    <div class="alert {{session()->get('alert-class')}} alert-dismissible fade show" id="alert" role="alert">
        {{ session()->get('message') }}
    </div>
@endif
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Student Information</h3>
    </div>
    <!-- /.card-header -->
    <!-- Validation Errors -->
    <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
    <!-- form start -->
    <form method="POST" action="{{route('admin.student.register')}}">
        @csrf
      <div class="card-body">         
        <!-- Student Code / RFID -->
        <div class="form-group">
            <x-label for="student_code" :value="__('Student Code')" />

            <x-input id="student_code" class="form-control" type="text" name="student_code" :value="old('student_code')" required autofocus />
        </div>

        <!-- Name -->
        <div class="form-group">
            <x-label for="name" :value="__('Name')" />

            <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required />
        </div>

        <!-- Email Address -->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>            
            <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" placeholder="Email" required />
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
  @if(session()->has('message'))
  $(document).ready(function() {        
      $("#alert").fadeTo(3000, 500).slideUp(500, function() {
          $("#alert").slideUp(500);
          $("#alert").remove();
          });
      });
  @endif
  </script>
@endpush