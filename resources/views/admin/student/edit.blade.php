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
        <form method="POST" action="{{ route('admin.student.update', $student) }}">
            @csrf
            @method('PUT')

            <div class="card-body">

                <!-- Academic Year -->
                <div class="form-group">
                    <x-label for="academic_year" :value="__('Academic Year')" />

                    <input id="academic_year" class="form-control" type="text" name="academic_year"
                        value="{{ $student->academic_year }}" required />
                </div>

                <!-- Student Code / RFID -->
                <div class="form-group">
                    <x-label for="student_code" :value="__('Student Code')" />

                    <input id="student_code" class="form-control" type="text" name="student_code"
                        value="{{ $student->student_code }}" required autofocus />
                </div>


                <div class="row">
                    <div class="col-3">
                        <!-- Courses -->
                        <div class="form-group">
                            <x-label for="course" :value="__('Course')" />
                            <select name="course" id="course" class="form-control">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @if ($student->course_id == $course->id)
                                        selected
                                @endif>{{ $course->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <!-- year -->
                        <div class="form-group">
                            <x-label for="year" :value="__('Year Level')" />
                            <select name="year" id="year" class="form-control">
                                @foreach ($yearlevels as $year)
                                    <option value="{{ $year }}" @if ($student->year == $year)
                                        selected
                                @endif>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-3">
                        <!-- Section -->
                        <div class="form-group">
                            <x-label for="section" :value="__('Section')" />
                            <select name="section" id="section" class="form-control">
                                @foreach ($sections as $section)
                                    <option value="{{ $section }}" @if ($student->section == $section)
                                        selected
                                @endif
                                >{{ $section }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <x-label for="name" :value="__('Name')" />

                    <input id="name" class="form-control" type="text" name="name" value="{{ $student->user->name }}"
                        required />
                </div>

                <!-- Email Address -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input id="email" class="form-control" type="email" name="email"
                        value="{{ $student->user->email }}" placeholder="Email" required />
                </div>

                <!-- Contact number -->
                <div class="form-group">
                    <x-label for="phone" :value="__('Guardian\'s Phone Number')" />

                    <input id="phone" class="form-control" type="tel" name="phone" value="{{ $student->phone }}"
                        required />
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
        </form>
    </div>
@endsection
