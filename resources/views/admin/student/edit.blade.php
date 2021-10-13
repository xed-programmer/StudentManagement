@extends('layouts.admin')

@section('header')
{{ __('Edit Student') }}
@endsection
   
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Student Information</h3>
    </div>
    <!-- /.card-header -->
    <!-- Validation Errors -->
    <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
    <!-- form start -->
    <form method="POST" action="{{route('admin.student.update', $student)}}">
        @csrf
        @method('PUT')
        
      <div class="card-body">         
        <!-- Student Code / RFID -->
        <div class="form-group">
            <x-label for="student_code" :value="__('Student Code')" />

            <input id="student_code" class="form-control" type="text" name="student_code" value="{{$student->student_code}}" required autofocus />
        </div>

        <!-- Name -->
        <div class="form-group">
            <x-label for="name" :value="__('Name')" />

            <input id="name" class="form-control" type="text" name="name" value="{{$student->users->name}}" required />
        </div>

        <!-- Email Address -->
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>            
            <input id="email" class="form-control" type="email" name="email" value="{{$student->users->email}}" placeholder="Email" required />
        </div>

        <!-- Contact number -->
        <div class="form-group">
          <x-label for="phone" :value="__('Guardian\'s Phone Number')" />

          <input id="phone" class="form-control" type="tel" name="phone" value="{{$student->phone}}" required />
        </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
      </div>
    </form>
  </div>
@endsection