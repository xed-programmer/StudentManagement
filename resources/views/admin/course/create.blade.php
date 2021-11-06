@extends('layouts.admin')

@push('links')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush
@section('header')
    {{ __('Add Course') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Course Information</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <form method="POST" action="{{ route('admin.course.create') }}">
            @csrf
            <div class="card-body">
                <!-- Code -->
                <div class="form-group">
                    <x-label for="code" :value="__('Code')" />

                    <x-input id="code" class="form-control" type="text" name="code" :value="old('code')" required
                        autofocus />
                </div>

                <!-- Name -->
                <div class="form-group">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required />
                </div>

                <!-- year -->
                <span name="year">Year</span>
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <x-input id="year1" type="checkbox" name="year1" :value="__('1ST')" />
                            <x-label for="year1" :value="__('1ST')" />
                        </div>
                        <div class="icheck-primary d-inline">
                            <x-input id="year2" type="checkbox" name="year2" :value="__('2ND')" />
                            <x-label for="year2" :value="__('2ND')" />
                        </div>
                        <div class="icheck-primary d-inline">
                            <x-input id="year3" type="checkbox" name="year3" :value="__('3RD')" />
                            <x-label for="year3" :value="__('3RD')" />
                        </div>
                        <div class="icheck-primary d-inline">
                            <x-input id="year4" type="checkbox" name="year4" :value="__('4TH')" />
                            <x-label for="year4" :value="__('4TH')" />
                        </div>
                    </div>
                </div>

                <!-- Section -->
                <span name='section'>Section</span>
                <div class="row">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <x-input id="section1" type="checkbox" name="section1" :value="__('A')" />
                            <x-label for="section1" :value="__('A')" />
                        </div>
                        <div class="icheck-primary d-inline">
                            <x-input id="section2" type="checkbox" name="section2" :value="__('B')" />
                            <x-label for="section2" :value="__('B')" />
                        </div>
                        <div class="icheck-primary d-inline">
                            <x-input id="section3" type="checkbox" name="section3" :value="__('C')" />
                            <x-label for="section3" :value="__('C')" />
                        </div>
                        <div class="icheck-primary d-inline">
                            <x-input id="section4" type="checkbox" name="section4" :value="__('D')" />
                            <x-label for="section4" :value="__('D')" />
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
        </form>
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
