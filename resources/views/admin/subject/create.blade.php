@extends('layouts.admin')

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

                <!-- Course -->
                <div class="form-group">
                    <x-label for="course" :value="__('Course')" />

                    <section class="form-control" name='course' id='course'>
                        @foreach ($courses as $c)
                            <option value="{{ $c->code }}">{{ $c->code }}</option>
                        @endforeach
                    </section>
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
