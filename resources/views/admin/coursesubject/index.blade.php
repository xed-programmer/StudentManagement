@extends('layouts.admin')

@section('header')
    {{ __('Course Subject') }}
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Course Subject Lists') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <a href="{{ route('admin.coursesubject.create') }}" class="btn btn-lg btn-success m-2">Add new Course
                    Subject</a>
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
                                        aria-label="Course Code: activate to sort column descending">Course Code</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Subject Name: activate to sort column ascending">Subject Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Year: activate to sort column ascending">Year</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Section: activate to sort column ascending">Section</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Units: activate to sort column ascending">Units</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Academic Year: activate to sort column ascending">Academic Year</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coursesubjects as $coursesubject)
                                    <tr>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $coursesubject->courses->code }}
                                        </td>
                                        <td class="dtr-control sorting_1" tabindex="0">
                                            {{ $coursesubject->subjects->name }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $coursesubject->year }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $coursesubject->section }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $coursesubject->units }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">
                                            {{ $coursesubject->academic_year }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.coursesubject.edit', $coursesubject) }}"
                                                    class="btn btn-sm btn-warning mr-2">Edit</a>
                                                <form action="{{ route('admin.coursesubject.delete', $coursesubject) }}"
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
