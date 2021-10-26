      {{-- Summernote --}}
      <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
      <script>
          $(document).ready(() => {
              $('#summernote').summernote({
                  height: 250,
                  focus: true,
                  toolbar: [
                      ['font', ['bold', 'italic', 'underline', 'clear']],
                      ['fontname', ['fontname']],
                      ['fontsize', ['fontsize']],
                      ['color', ['color']],
                      ['para', ['paragraph']],
                      ['table', ['table']],
                      ['insert', ['link', 'video']],
                      ['view', ['fullscreen', 'codeview', 'help']],
                  ],
              });
          });
      </script>
