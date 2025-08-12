<script>
  $(document).on('click', '.form-data-button', function() {
    // get value from data-id="" attribute
    var id = $(this).attr("data-id");
    // ajax get
    $.ajax({
      type: "GET",
      url: "{{ url('character/' . $character->slug . '/image') }}/" + id,
      dataType: "text"
    }).done(function(res) {
      $("#main-tab").fadeOut(200, function() {
        $("#main-tab").html(res);
        $('#main-tab').find('[data-bs-toggle="toggle"]').bootstrapToggle();
        $('.reupload-image').on('click', function(e) {
          e.preventDefault();
          loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/reupload", 'Reupload Image');
        });
        $('.active-image').on('click', function(e) {
          e.preventDefault();
          loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/active", 'Set Active');
        });
        $('.delete-image').on('click', function(e) {
          e.preventDefault();
          loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/delete", 'Delete Image');
        });
        $('.edit-features').on('click', function(e) {
          e.preventDefault();
          loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/traits", 'Edit Traits');
        });
        $('.edit-notes').on('click', function(e) {
          e.preventDefault();
          $("div.imagenoteseditingparse").load("{{ url('admin/character/image') }}/" + $(this).data('id') +
            "/notes",
            function() {
              tinymce.init({
                selector: '.imagenoteseditingparse .wysiwyg',
                height: 500,
                menubar: false,
                convert_urls: false,
                plugins: [
                  'advlist forecolor fontselect fontsizeselect  autolink lists link image charmap print preview anchor',
                  'searchreplace visualblocks code fullscreen spoiler',
                  'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect fontselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
                content_css: [
                  '{{ asset('css/app.css') }}',
                  '{{ asset('css/vendor/lorekeeper.css') }}'
                ],
                spoiler_caption: 'Toggle Spoiler',
                target_list: false,
                indent_before: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
                  'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
                indent_after: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
                  'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
                whitespace_elements: 'p pre script noscript style textarea video audio iframe object code',

              });
            });
          $(".edit-notes").remove();
        });
        $('.edit-credits').on('click', function(e) {
          e.preventDefault();
          loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/credits",
            'Edit Image Credits');
        });
        $("#main-tab").fadeIn(200);
      });
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert("AJAX call failed: " + textStatus + ", " + errorThrown);
    });
  });
</script>
