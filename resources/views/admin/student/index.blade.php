@extends('layouts.admin')

@section('header')
{{ __('Students') }}
@endsection        

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
        {{ session()->get('message') }}
    </div>
@endif
<div class="card">
    <div class="card-header">
      <h3 class="card-title">{{__('Student Lists')}}</h3>
    </div>    
    <div class="card-body">
        <div class="row">
            <a href="{{route('admin.student.register')}}" class="btn btn-lg btn-success m-2">Add new student</a>
        </div>
        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Student Code: activate to sort column ascending">Student Code</th>
                                <th tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $i => $student)
                                <tr>
                                    <td class="dtr-control sorting_1" tabindex="0">{{$student->users->name}}</td>
                                    <td class="dtr-control sorting_1" tabindex="0">{{$student->student_code}}</td>
                                    <td class="dtr-control sorting_1" tabindex="0">
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
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
@endsection

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<!-- Page specific script -->
<script>
    $(function () {
      $("#example1").DataTable({
        "paging": true,"responsive": true, "lengthChange": false, "autoWidth": false,"ordering": true,
        "info": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    @if(session()->has('message'))
    $(document).ready(function() {        
        $("#alert").fadeTo(3000, 500).slideUp(500, function() {
            $("#alert").slideUp(500);
            });
        });
    @endif

  </script>
@endpush
