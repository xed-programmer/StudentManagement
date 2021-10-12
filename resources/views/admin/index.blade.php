@extends('layouts.admin')

        
@section('header')
{{ __('Admin') }}
@endsection        

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
        {{ session()->get('message') }}
    </div>
@endif
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Student Lists</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <div class="row">

        </div>
<div class="row">
    <div class="col-sm-12">
        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline collapsed" role="grid" aria-describedby="example1_info">
            <thead>
                <tr role="row">
                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">Name</th>
                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Role: activate to sort column ascending">Role</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($users as $i => $user)
                    <tr>
                        <td class="dtr-control sorting_1" tabindex="0">{{$user->name}}</td>
                        <td>
                            @if (Auth::user()->id != $user->id)
                                @if ($user->hasRole('admin'))
                                <form action="{{route('admin.remove.permission', $user)}}" method="post">
                                    @csrf
                                    <input class="btn btn-danger" type="submit" value="Remove Admin Permission">
                                </form>                                     
                                @else
                                <form action="{{route('admin.give.permission', $user)}}" method="post">
                                    @csrf
                                    <input class="btn btn-success" type="submit" value="Give Admin Permission">
                                </form>                                    
                                @endif                                                    
                            @endif
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
            {{-- <tfoot>
                <tr>
                    <th rowspan="1" colspan="1">Rendering engine</th>
                    <th rowspan="1" colspan="1">Browser</th>
                </tr>
            </tfoot> --}}
      </table>
    </div>
</div>
</div>
    </div>
    <!-- /.card-body -->
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
