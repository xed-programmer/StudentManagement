@extends('layouts.admin')

@push('links')
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@section('header')
    {{ __('Add User') }}
@endsection
@section('content')
    @if (session()->has('message'))
        <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" id="alert" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">User Account Information</h3>
        </div>
        <!-- /.card-header -->
        <!-- Validation Errors -->
        <x-auth-validation-errors class="m-4 text-danger" :errors="$errors" />
        <!-- form start -->
        <form method="POST" action="{{ route('admin.user.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="card-body">

                <!-- Role -->
                <div class="form-group">
                    <x-label for="role" :value="__('Role')" />

                    <select name="role" id="role" class="form-control w-50">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @if (in_array(
    $role->id,
    $user->roles()->pluck('id')->ToArray(),
)) selected @endif>
                                {{ Str::ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Building -->
                <div class="form-group">
                    <x-label for="building" :value="__('building')" />

                    <select name="building" id="building" class="form-control w-50">
                        @foreach ($buildings as $building)
                            <option value="{{ $building->name }}" @if (in_array(
    $building->id,
    $user->buildings()->pluck('id')->ToArray(),
)) selected @endif>
                                {{ Str::ucfirst($building->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <x-label for="name" :value="__('Name')" />

                    <x-input id="name" class="form-control" type="text" name="name" :value="$user->name" required />
                </div>

                <!-- Email Address -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <x-input id="email" class="form-control" type="email" name="email" :value="$user->email"
                        placeholder="Email" required />
                </div>

                <!-- Contact number -->
                <div class="form-group">
                    <x-label for="phone" :value="__('Phone Number')" />

                    <input id="phone" class="form-control" type="tel" name="phone" value="{{ $user->phone_number }}"
                        required />
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
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
