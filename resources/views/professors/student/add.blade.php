@extends('layouts.professor')

@section('header')
    {{ __('Add Student') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
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
        <div class="card-body">
            <form method="POST" action="{{ route('professor.student.data') }}" id="form_search">
                @csrf
                <div class="row">
                    <div class="col-3">
                        <!-- Courses -->
                        <div class="form-group">
                            <x-label for="course" :value="__('Course')" />
                            <select name="course" id="course" class="form-control">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @if (old('course->code') == $course->code)
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
                                    <option value="{{ $year }}" @if (old('year') == $year)
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
                                    <option value="{{ $section }}" @if (old('section') == $section)
                                        selected
                                @endif
                                >{{ $section }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <!-- Search Button -->
                    <div class="form-group">
                        <button id='search_student' class="btn btn-sm btn-info">Search</button>
                    </div>
                </div>
            </form>
            <form method="POST" action="{{ route('professor.student.add', $schedule) }}">
                @csrf
                <div class="row">
                    <!-- Students -->
                    <div class="form-group">
                        <x-label for="student" :value="__('Student')" />
                        <select name="student" id="student" class="form-control">
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                </div>
            </form>
        </div>
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

        $(document).ready(function() {
            $('#form_search').on('submit', function(e) {
                var form = $(this);
                var formData = form.serialize();

                $.ajax({
                        type: form.attr('method'),
                        url: form.attr('action'),
                        data: formData,
                        encode: true,
                    })
                    .done((data) => {
                        $('#student option').remove();
                        data.forEach(d => {
                            $('#student').append(new Option(d.user.name, d.id));
                        });
                    });
                e.preventDefault();
            });
        });
    </script>
@endpush
