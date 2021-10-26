@extends('layouts.admin')

@push('links')
    {{-- SUmmernote --}}
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
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
                        <form id="postForm" action="{{ route('admin.posts.store') }}" method="POST" class="m-auto w-75">
                            @csrf
                            <textarea name="post" id="summernote" cols="30" rows="10" required></textarea>
                            <input type="text" id="plain_post" name="plain_post" hidden>
                            <input type="submit" value="Post" onclick="getPlainPost()"
                                class="btn btn-info btn-lg float-right">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Post Lists') }}</h3>
                </div>
                <div class="card-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1"
                                    class="table table-bordered table-striped dataTable dtr-inline collapsed" role="grid"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example1"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Post: activate to sort column descending">Post</th>
                                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                                colspan="1" aria-label="Created At: activate to sort column ascending">
                                                Created At</th>
                                            <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posts as $post)
                                            <tr>
                                                <td class="dtr-control sorting_1" tabindex="0">
                                                    {!! $post->body !!}
                                                </td>
                                                <td class="dtr-control sorting_1" tabindex="0">
                                                    {{ $post->created_at->diffForHumans() }}</td>
                                                <td class="dtr-control sorting_1" tabindex="0">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('admin.posts.edit', $post) }}"
                                                            class="btn btn-sm btn-warning mr-2">Edit</a>
                                                        <form action="{{ route('admin.posts.delete', $post) }}"
                                                            method="POST"
                                                            onclick="return confirm('Do you want to delete this data?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        // $(document).ready(( => {
        //     $('#postForm').on('submit', (e) => {
        //         e.preventDefault();
        //         var plain_body = $($('#summernote').summernote('code')).text();
        //         $('#plain_post').val(plain_body);

        //         $.ajax({
        //             method: 'POST',
        //             url: "{{ route('admin.posts.store') }}",
        //             data: $$('#postForm').serialize(),
        //             success: (response) => {
        //                 alert("Success");
        //             },
        //             error: (error) => {
        //                 alert('Error');
        //             }
        //         });
        //     });
        // }));

        function getPlainPost() {
            var plain_body = $($('#summernote').summernote('code')).text();
            $('#plain_post').val(plain_body);
        }
    </script>
    @component('components.data-table-links-component')

    @endcomponent
@endpush
