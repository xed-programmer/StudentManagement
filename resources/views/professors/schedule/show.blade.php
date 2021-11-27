@extends('layouts.professor')


@section('header')
    {{ __('Class Schedules') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Primary Outline</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                    The body of the card
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
