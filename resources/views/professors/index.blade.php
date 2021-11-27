@extends('layouts.professor')


@section('header')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $schedule_count }}</h3>

                    <p>Class Schedule</p>
                </div>
                <div class="icon">
                    <i class="far fa-calendar-alt"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
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
