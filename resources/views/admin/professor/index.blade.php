@extends('layouts.admin')

@section('header')
    {{ __('Professors') }}
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Professors Lists') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <a href="{{ route('admin.professor.register') }}" class="btn btn-lg btn-success m-2">Add new Professor</a>
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
                                        aria-label="Student Code: activate to sort column ascending">Units</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($professors as $professor)
                                    <tr>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $professors->user->name }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $professors->units }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.student.edit', $student) }}"
                                                    class="btn btn-sm btn-warning mr-2">Edit</a>
                                                <form action="{{ route('admin.student.delete', $student) }}" method="POST"
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
