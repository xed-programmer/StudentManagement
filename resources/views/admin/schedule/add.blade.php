@extends('layouts.admin')

@push('links')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush


@section('header')
    {{ __('Add Schedule') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Schedule Information</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <form method="POST" action="{{ route('admin.schedule.add') }}">
            @csrf
            <div class="card-body">

                <!-- Professor -->
                <div class="form-group">
                    <x-label for="professor" :value="__('Professor')" />

                    <select name="professor" id="professor" class="form-control">
                        @foreach ($professors as $professor)
                            <option value="{{ $professor->id }}" @if (old('professor->user->name') == $professor->user->name)
                                selected
                        @endif>{{ $professor->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-6">
                        <!-- Course -->
                        <span name="course">Course</span>
                        <div class="form-group clearfix">
                            @forelse ($courses as $i => $c)
                                <div class="icheck-primary d-inline">
                                    <x-input id="course{{ $i }}" type="radio" name="course" :value="$c->code" />
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
                                <x-input id="year1" type="radio" name="year" :value="__('1ST')" />
                                <x-label for="year1" :value="__('1ST')" />
                            </div>
                            <div class="icheck-primary d-inline">
                                <x-input id="year2" type="radio" name="year" :value="__('2ND')" />
                                <x-label for="year2" :value="__('2ND')" />
                            </div>
                            <div class="icheck-primary d-inline">
                                <x-input id="year3" type="radio" name="year" :value="__('3RD')" />
                                <x-label for="year3" :value="__('3RD')" />
                            </div>
                            <div class="icheck-primary d-inline">
                                <x-input id="year4" type="radio" name="year" :value="__('4TH')" />
                                <x-label for="year4" :value="__('4TH')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <span name='section'>Section</span>
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <x-input id="section1" type="radio" name="section" :value="__('A')" />
                                <x-label for="section1" :value="__('A')" />
                            </div>
                            <div class="icheck-primary d-inline">
                                <x-input id="section2" type="radio" name="section" :value="__('B')" />
                                <x-label for="section2" :value="__('B')" />
                            </div>
                            <div class="icheck-primary d-inline">
                                <x-input id="section3" type="radio" name="section" :value="__('C')" />
                                <x-label for="section3" :value="__('C')" />
                            </div>
                            <div class="icheck-primary d-inline">
                                <x-input id="section4" type="radio" name="section" :value="__('D')" />
                                <x-label for="section4" :value="__('D')" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <!-- Time -->
                            <span name="time">Time</span>
                            <div class="row">
                                <div class="col-4">
                                    <!-- Start Time -->
                                    <div class="form-group">
                                        <x-label for="start" :value="__('Start')" />

                                        <x-input id="start" class="form-control" type="time" name="start"
                                            :value="old('start')" required />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- End Time -->
                                    <div class="form-group">
                                        <x-label for="end" :value="__('End')" />

                                        <x-input id="end" class="form-control" type="time" name="end" :value="old('end')"
                                            required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <!-- Days -->
                        <span name='day'>Days</span>
                        <div class="form-group clearfix">
                            @forelse ($days as $i => $day)
                                <div class="icheck-primary d-inline">
                                    <x-input id="day{{ $i }}" type="checkbox" name="{{ $day }}"
                                        :value="$day" />
                                    <x-label for="day{{ $i }}" :value="$day" />
                                </div>
                            @empty
                                <span class="form-control text-muted ">No Days available</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <x-label for="subject" :value="__('Subject')" />

                    <select name="subject" id="subject" class="form-control">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->code }}" @if (old('subject->code') == $subject->code)
                                selected
                        @endif>{{ $subject->code }} - {{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
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
