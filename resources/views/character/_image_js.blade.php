<script>
  $(document).ready(function() {
    $('.edit-features').on('click', function(e) {
      e.preventDefault();
      loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/traits", 'Edit Traits');
    });
    $('.edit-notes').on('click', function(e) {
      e.preventDefault();
      $("div.imagenoteseditingparse").load("{{ url('admin/character/image') }}/" + $(this).data('id') + "/notes",
        function() {
          tinymce.init({
            selector: '.imagenoteseditingparse .wysiwyg',
            height: 500,
            menubar: false,
            convert_urls: false,
            plugins: [
              'advlist textcolor fontselect fontsizeselect  autolink lists link image charmap print preview anchor',
              'searchreplace visualblocks code fullscreen spoiler',
              'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect fontselect fontsizeselect | bold italic textcolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
            content_css: [
              '{{ asset('css/app.css') }}',
              '{{ asset('css/vendor/lorekeeper.css') }}'
            ],
            indent_before: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
              'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
            indent_after: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
              'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
            whitespace_elements: 'p pre script noscript style textarea video audio iframe object code',
            spoiler_caption: 'Toggle Spoiler',
            target_list: false
          });
        });
      $(".edit-notes").remove();
    });
    $('.edit-credits').on('click', function(e) {
      e.preventDefault();
      loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/credits", 'Edit Image Credits');
    });
    $('.edit-credits').on('click', function(e) {
      e.preventDefault();
      loadModal("{{ url('admin/character/image') }}/" + $(this).data('id') + "/credits", 'Edit Image Credits');
    });
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
    $('.edit-stats').on('click', function(e) {
      e.preventDefault();
      loadModal("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/" + $(this).data(
        '{{ $character->is_myo_slot ? 'id' : 'slug' }}') + "/stats", 'Edit Character Stats');
    });
    $('.edit-lineage').on('click', function(e) {
      e.preventDefault();
      loadModal("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/" + $(this).data(
        '{{ $character->is_myo_slot ? 'id' : 'slug' }}') + "/lineage", 'Edit Character Lineage');
    });
    $('.edit-description').on('click', function(e) {
      e.preventDefault();
      $("div.descriptioneditingparse").load("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/" +
        $(this).data('{{ $character->is_myo_slot ? 'id' : 'slug' }}') + "/description",
        function() {
          tinymce.init({
            selector: '.descriptioneditingparse .wysiwyg',
            height: 500,
            menubar: false,
            convert_urls: false,
            plugins: [
              'advlist textcolor fontselect fontsizeselect  autolink lists link image charmap print preview anchor',
              'searchreplace visualblocks code fullscreen spoiler',
              'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect fontselect fontsizeselect | bold italic textcolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
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
      $(".edit-description").remove();
    });
    $('.delete-character').on('click', function(e) {
      e.preventDefault();
      loadModal("{{ url($character->is_myo_slot ? 'admin/myo/' : 'admin/character/') }}/" + $(this).data(
        '{{ $character->is_myo_slot ? 'id' : 'slug' }}') + "/delete", 'Delete Character');
    });
    $('.edit-image-colours').on('click', function(e) {
      e.preventDefault();
      $('#colour-collapse-' + $(this).data('id')).collapse('toggle');
    });
  });
</script>
