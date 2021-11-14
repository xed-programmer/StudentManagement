@extends('layouts.admin')

@push('links')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@section('header')
    {{ __('Add Subject') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Subject Information</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <form method="POST" action="{{ route('admin.subject.create') }}">
            @csrf
            <div class="card-body">
                <!-- Academic Year -->
                <div class="form-group">
                    <x-label for="academic_year" :value="__('Academic Year')" />

                    <x-input id="academic_year" class="form-control" type="text" name="academic_year"
                        value="{{ $acad_year }}" required autofocus />
                </div>

                <div class="row">
                    <div class="col-6">
                        <!-- Course -->
                        <span name="course">Course</span>
                        <div class="form-group clearfix">
                            @forelse ($courses as $i => $c)
                                <div class="icheck-primary d-inline">
                                    <x-input id="course{{ $i }}" type="checkbox" name="{{ $c->code }}"
                                        :value="$c->code" />
                                    <x-label for="course{{ $i }}" :value="$c->code" />
                                </div>
                            @empty
                                <span class="form-control text-muted ">No Course available</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-3">
                        <!-- year -->
                        <span name="year">Year</span>
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

                    <div class="col-3">
                        <span name='section'>Section</span>
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
                </div>

                <!-- Code -->
                <div class="form-group">
                    <x-label for="code" :value="__('Code')" />

                    <x-input id="code" class="form-control" type="text" name="code" :value="old('code')" required />
                </div>

                <!-- Description -->
                <div class="form-group">
                    <x-label for="description" :value="__('Description')" />

                    <x-input id="description" class="form-control" type="text" name="description"
                        :value="old('description')" required />
                </div>

                <!-- Units -->
                <div class="form-group">
                    <x-label for="units" :value="__('Units')" />

                    <x-input id="units" class="form-control" type="number" name="units" :value="old('units')" required />
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
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
