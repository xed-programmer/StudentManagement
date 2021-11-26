@extends('layouts.admin')

@section('header')
    {{ __('Schedules') }}
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Schedule Lists') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <a href="{{ route('admin.student.register') }}" class="btn btn-lg btn-success m-2">Add new Schedule</a>
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
                                        aria-label="Subject: activate to sort column descending">Subject</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Course: activate to sort column ascending">Course</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Section: activate to sort column ascending">Section</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Year: activate to sort column ascending">Year</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Professor: activate to sort column ascending">Professor</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Day: activate to sort column ascending">Day</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Start Time: activate to sort column ascending">Start Time</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="End Time: activate to sort column ascending">End Time</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Units: activate to sort column ascending">Units</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="School Year: activate to sort column ascending">School Year</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->subjects->name }}
                                        </td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->courses->name }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->year }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->professors->name }}
                                        </td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->day }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->time_start }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->time_end }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->units }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $schedule->school_year }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.schedule.edit', $schedule) }}"
                                                    class="btn btn-sm btn-warning mr-2">Edit</a>
                                                <form action="{{ route('admin.schedule.delete', $schedule) }}"
                                                    method="POST"
                                                    onclick="return confirm('Do you want to delete this data?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
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
@endpush
