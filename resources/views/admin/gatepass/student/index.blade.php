@extends('layouts.admin')


@section('header')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <h3 class="card-title" id="table-title">{{ __('Student Gate Pass') }}</h3>
            </div>
            <div class="card-body">
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
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Student Code: activate to sort column ascending">Student
                                            Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Course: activate to sort column ascending">Course</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Year Level: activate to sort column ascending">Year
                                            Level</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Section: activate to sort column ascending">Section</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Day: activate to sort column ascending">Day</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Time: activate to sort column ascending">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $attendance->student->user->name }}
                                            </td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $attendance->student->student_code }}
                                            </td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $attendance->student->course }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $attendance->student->year }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $attendance->student->section }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">{{ $attendance->status }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $attendance->created_at->format('D, M j Y') }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $attendance->created_at->format('h:i a') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @component('components.data-table-links-component')
    @endcomponent
@endpush