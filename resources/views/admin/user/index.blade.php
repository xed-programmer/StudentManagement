@extends('layouts.admin')

@section('header')
    {{ __('Users') }}
@endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" id="table-title">{{ __('User Lists') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <a href="{{ route('admin.user.register') }}" class="btn btn-lg btn-success m-2">Create new User</a>
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
                                        aria-label="Email: activate to sort column ascending">Email</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Role: activate to sort column ascending">Role</th>
                                    <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $user->name }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $user->email }}</td>
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $user->role }}</td>
                                        </td>
                                        <td class="dtr-control sorting_1" tabindex="0">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.user.edit', $user) }}"
                                                    class="btn btn-sm btn-warning mr-2">Edit</a>
                                                <form action="{{ route('admin.user.delete', $user) }}" method="POST"
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
