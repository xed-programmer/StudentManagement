@extends('layouts.professor')


@section('header')
    {{ $schedule->coursesubjects->courses->code }} {{ $schedule->coursesubjects->year }}
    {{ $schedule->coursesubjects->section }}
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $schedule->coursesubjects->courses->code }} {{ $schedule->coursesubjects->year }}
                {{ $schedule->coursesubjects->section }} {{ __('Lists') }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <a href="{{ route('professor.student.add', $schedule) }}" class="btn btn-lg btn-success m-2">Add
                    Student</a>
            </div>
            <div class="row">
                <a href="{{ route('professor.student.attendance.create', ['schedule' => $schedule, 'student' => $students]) }}"
                    class="btn btn-lg btn-info m-2">Attendance</a>
            </div>
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed"
                            role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Name: activate to sort column descending">Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Student Code: activate to sort column ascending">Student Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $student->user->name }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $student->student_code }}</td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @component('components.data-table-links-component')

    @endcomponent

    <!-- Page specific script -->
    <script>
        @if (session()->has('message'))
            $(document).ready(function() {
            $("#alert").fadeTo(3000, 500).slideUp(500, function() {
            $("#alert").slideUp(500);
            });
            });
        @endif
    </script>
@endpush
