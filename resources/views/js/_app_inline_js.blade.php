<script>
  $(document).on('focusin', function(e) {
    if ($(e.target).closest(
        ".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
      e.stopImmediatePropagation();
    }
  });
  $(function() {
    $('[data-toggle="tooltip"]').tooltip({
      html: true
    });
    $('.cp').colorpicker();
    tinymce.init({
      selector: '.wysiwyg',
      height: 500,
      menubar: false,
      convert_urls: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen spoiler',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
      content_css: [
        '{{ asset('css/app.min.css') }}',
        '{{ asset('css/vendor/lorekeeper.css') }}'
      ],
      spoiler_caption: 'Toggle Spoiler',
      target_list: false
    });
    bsCustomFileInput.init();
    var $mobileMenuButton = $('#mobileMenuButton');
    var $sidebar = $('#sidebar');
    $('#mobileMenuButton').on('click', function(e) {
      e.preventDefault();
      $sidebar.toggleClass('active');
    });

    $('.inventory-log-stack').on('click', function(e) {
      e.preventDefault();
      loadModal("{{ url('items') }}/" + $(this).data('id') + "?read_only=1", $(this).data(
        'name'));
    });

    $('.spoiler-text').hide();
    $('.spoiler-toggle').click(function() {
      $(this).next().toggle();
    });
  });

  $(document).ready(function() {
    var $imageMaps = $('img[usemap]');
    // loop through each element
    $imageMaps.each(function() {
      // get the map name
      var mapName = $(this).attr('usemap').replace('#', '');
      // get the map object
      var $map = $('map[name="' + mapName + '"]');
      // resize image map
      $map.imageMapResize();
    });
  });

  $('.tooltip-bot, .tooltip-bot a, .nav-social-links a').tooltip({
    placement: "top"
  });
  $(document).mousemove(function(e) {
    // check if $('#Image-Maps-Com-process-map') exists
    if ($('#Image-Maps-Com-process-map').length == 0) {
      return;
    }
    var mouseX = e.pageX - $('#Image-Maps-Com-process-map').offset().left;
    var mouseY = e.pageY - $('#Image-Maps-Com-process-map').offset().top - 5;
    $('.tooltip').css({
      'top': mouseY,
      'left': mouseX
    }).fadeIn('slow');
  });
</script>
{{-- Image Blocking --}}
@if (Auth::check() && Auth::user()->blockedImages()->count())
  <style>
    @foreach (Auth::user()->blockedImages as $image)
      [src="{{ $image->objectImageUrl() }}"] {
        filter: blur(5px);
      }
    @endforeach
  </style>
@endif
