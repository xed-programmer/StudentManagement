@extends('layouts.admin')


@section('header')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $users }}</h3>

                    <p>Administrator</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $student }}</h3>

                    <p>Students</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <a href="{{ route('admin.student.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $guardian }}</h3>

                    <p>Guardians</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <a href="{{ route('admin.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $post }}</h3>

                    <p>Announcements</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

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

    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <h3 class="card-title" id="table-title2">{{ __('Visitor\'s Gate Pass') }}</h3>
            </div>
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-striped dataTable dtr-inline collapsed"
                                role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending">Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Status: activate to sort column ascending">Destination
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Day: activate to sort column ascending">Day</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                            colspan="1" aria-label="Time: activate to sort column ascending">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitors as $visitor)
                                        <tr>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $visitor->name }}
                                            </td>
                                            <td class="dtr-control sorting_1" tabindex="0">{{ $visitor->destination }}
                                            </td>
                                            <td class="dtr-control sorting_1" tabindex="0">{{ $visitor->status }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $visitor->created_at->format('D, M j Y') }}</td>
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ $visitor->created_at->format('h:i a') }}</td>
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
    <script>
        $(function() {
            $("#example2").DataTable({
                "aaSorting": [],
                "paging": true,
                'autoWidth': false,
                "ordering": true,
                "info": true,
                "scrollX": true,
                "scrollY": true,
                "buttons": [
                    'copy',
                    {
                        extend: 'csv',
                        title: $("#table-title2").text(),
                        messageTop: 'As of ' + moment().format('MMMM DD, YYYY')
                    },
                    {
                        extend: 'print',
                        title: $("#table-title2").text(),
                        messageTop: 'As of ' + moment().format('MMMM DD, YYYY')
                    },
                    {
                        extend: 'excel',
                        title: $("#table-title2").text(),
                        messageTop: 'As of ' + moment().format('MMMM DD, YYYY')
                    },
                    {
                        extend: 'pdf',
                        title: $("#table-title2").text(),
                        messageTop: 'As of ' + moment().format('MMMM DD, YYYY')
                    },
                    {
                        extend: 'print',
                        title: $("#table-title2").text(),
                        messageTop: 'As of ' + moment().format('MMMM DD, YYYY')
                    }
                ]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
