@extends('layouts.admin')

@push('links')
    {{-- SUmmernote --}}
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endpush
@section('header')
    POST
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form id="postForm" action="{{ route('admin.posts.update', $post) }}" method="POST"
                            class="m-auto w-75">
                            @csrf
                            @method('PUT')
                            <textarea name="post" id="summernote" cols="30" rows="10" required></textarea>
                            <input type="text" id="plain_post" name="plain_post" hidden>
                            <input type="submit" value="Update" onclick="getPlainPost()"
                                class="btn btn-info btn-lg float-right">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    @component('components.summernote-scripts')

    @endcomponent
    <script>
        $(document).ready(() => {
            $('#summernote').summernote('code', @json(old('post') ? old('post') : $post->body));
        });

        function getPlainPost() {
            var plain_body = $($('#summernote').summernote('code')).text();
            $('#plain_post').val(plain_body);
        }
    </script>
@endpush
