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
      var chartab1 = $("#char-col");
      var infotab1 = $("#info-col")
      var duration = 200;
      $('#main-tab').fadeOut(duration);
      chartab1.fadeOut(duration);
      // infotab1.fadeOut(duration);
      setTimeout(async () => {
        // $("#info-col").add("#char-col").fadeOut(2000, function() {
        chartab1.remove();
        infotab1.remove();
        $("#main-tab").html(res);
        // $("#main-tab").insertBefore(res).insertBefore("div");
        $('#main-tab').find('[data-bs-toggle="toggle"]').bootstrapToggle();
        $('.reupload-image').on('click', function(e) {
          e.preventDefault();
          loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/reupload",
            'Reupload Image');
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
        $($("#main-tab").html()).insertBefore("#main-tab");
        $("#main-tab").empty();
        var chartab2 = $("#char-col");
        var infotab2 = $("#info-col");
        chartab2.fadeOut(0);
        // infotab2.fadeOut(0);
        chartab2.fadeIn(duration);
        // infotab2.fadeIn(duration);
      }, duration);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert("AJAX call failed: " + textStatus + ", " + errorThrown);
    });
  });
</script>
