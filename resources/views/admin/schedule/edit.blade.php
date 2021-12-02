@extends('layouts.admin')

@push('links')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush


@section('header')
    {{ __('update Schedule') }}
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
        <form method="POST" action="{{ route('admin.schedule.update', $schedule) }}">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Professor -->
                <div class="form-group">
                    <x-label for="professor" :value="__('Professor')" />

                    <select name="professor" id="professor" class="form-control">
                        @foreach ($professors as $professor)
                            <option value="{{ $professor->id }}" @if ($schedule->professors->user->name == $professor->user->name)
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
                                    <input type="radio" name="course" id="course{{ $i }}"
                                        value={{ $c->code }} @if ($schedule->coursesubjects->course_id == $c->id)
                                    checked
                            @endif>

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
                        @foreach ($yearLevels as $i => $year)
                            <div class="icheck-primary d-inline">
                                <input type="radio" name="year" id="year{{ $i }}" value={{ $year }}
                                    @if ($schedule->coursesubjects->year == $year)
                                checked
                        @endif
                        >
                        <x-label for="year{{ $i }}" :value="$year" />
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-3">
                <span name='section'>Section</span>
                <div class="form-group clearfix">
                    @foreach ($sections as $i => $section)
                        <div class="icheck-primary d-inline">
                            <input type="radio" name="section" id="section{{ $i }}" value={{ $section }}
                                @if ($schedule->coursesubjects->section == $section)
                            checked
                    @endif>
                    <x-label for="section{{ $i }}" :value="$section" />
                </div>
                @endforeach
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
                                :value="date('H:i', $schedule->time_start)" required />
                        </div>
                    </div>
                    <div class="col-4">
                        <!-- End Time -->
                        <div class="form-group">
                            <x-label for="end" :value="__('End')" />

                            <x-input id="end" class="form-control" type="time" name="end"
                                :value="date('H:i', $schedule->time_end)" required />
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
                        <input type="radio" name="day" id="day{{ $i }}" value={{ $day }} @if ($schedule->day == $day)
                        checked
                @endif>
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
                <option value="{{ $subject->code }}" @if ($schedule->coursesubjects->subjects->id == $subject->id)
                    selected
            @endif>{{ $subject->coursesubjects->units }} units - {{ $subject->code }}
            - {{ $subject->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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
