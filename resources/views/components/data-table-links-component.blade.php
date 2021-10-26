 <!-- DataTables  & Plugins -->
 <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
 <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
 <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
 <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

 <!-- Page specific script -->
 <script>
     $(function() {
         $("#example1").DataTable({
             "paging": true,
             "responsive": true,
             "lengthChange": false,
             "autoWidth": false,
             "ordering": true,
             "info": true,
             "buttons": ["copy", "csv", "excel", "pdf", "print"]
         }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
     });

     @if (session()->has('message'))
         $(document).ready(function() {
         $("#alert").fadeTo(3000, 500).slideUp(500, function() {
         $("#alert").slideUp(500);
         $("#alert").remove();
         });
         });
     @endif
 </script>
