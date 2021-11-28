@extends('layouts.professor')


@section('header')
    {{ __('Class Schedules') }}
@endsection

@section('content')
    <div class="row">
        @foreach ($days as $day)
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{ $day }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="display: block;">
                        @if ($schedules->has($day))
                            <div class="row flex">
                                @foreach ($schedules[$day] as $schedule)
                                    <div class="col-md-12 col-lg-6 col-xl-4">
                                        <div class="card mb-2 bg-gradient-dark">
                                            <img class="card-img-top bg-blue-500"
                                                src="{{ asset('dist/img/img_code.jpg') }}" alt="Dist Photo 1">
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-primary text-white">
                                                    {{ $schedule->coursesubjects->subjects->code }}</h5>
                                                <h5 class="card-title text-primary text-white">
                                                    {{ $schedule->coursesubjects->subjects->name }}</h5>
                                                <p class="card-text text-white pb-2 pt-1">
                                                    {{ $schedule->timestampToTime($schedule->time_start) }} -
                                                    {{ $schedule->timestampToTime($schedule->time_end) }}</p>
                                                <a href="{{ route('professor.class.show', $schedule) }}"
                                                    class="text-white">{{ $schedule->coursesubjects->courses->code }}
                                                    {{ $schedule->coursesubjects->year }}
                                                    {{ $schedule->coursesubjects->section }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <!-- Page specific script -->
    <script>
        @if (session()->has('message'))
            $(document).ready(function() {
            $("#alert").fadeTo(3000, 500).slideUp(500, function() {
            $("#alert").slideUp(500);
            });
            });
        @endif
    </script>
@endpush
