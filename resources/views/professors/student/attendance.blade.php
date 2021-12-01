@extends('layouts.professor')

@section('header')
    {{ __('Attendance') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $schedule->coursesubjects->courses->code }}
                {{ $schedule->coursesubjects->year }}
                {{ $schedule->coursesubjects->section }} {{ __('Lists') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <div class="card-body">
            <div class="row">
                <p>Total Students: {{ $students->count() }}</p>
            </div>
            <form method="POST" action="{{ route('professor.student.attendance.store') }}">
                @csrf

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Present</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $i => $student)

                            <tr>
                                <th scope="row">{{ $i + 1 }}</th>
                                <td>{{ $student->user->name }}</td>
                                <td>
                                    <input name="{{ $student->student_code }}" type="checkbox" class="form-control" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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
    </script>
@endpush
