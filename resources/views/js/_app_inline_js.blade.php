<script>
  $(document).on('focusin', function(e) {
    if ($(e.target).closest(
        ".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
      e.stopImmediatePropagation();
    }
  });
  $(function() {
    $('.cp').colorpicker();

    // Sets up tooltip hovers
    $('[data-bs-toggle="tooltip"]').tooltip({
      html: true,
      placement: "bottom",
      container: '#app',
      customClass: 'tooltip-fix',
    });

    // TinyMCE configuration
    tinymce.init({
      selector: '.wysiwyg',
      license_key: 'gpl',
      height: 500,
      menubar: false,
      convert_urls: false,
      plugins: [
        'advlist forecolor fontselect fontsizeselect autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen spoiler',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect fontselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
      content_css: [
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

    // Mobile Sidebar toggle
    $('#mobile-sidebar-toggle').on('click', (e) => {
      e.preventDefault();
      $('#sidebar-container').toggleClass('show')
    })

    // File picker intialization
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

    // Sidebar Toggling
    document.querySelectorAll('.details-sb').forEach(detail => {
      // setRows(detail);
      let summary = detail.querySelector(":scope > summary");
      summary.addEventListener('click', () => {
        detail.toggleAttribute("data-open");
        // setRows(detail);
      });
    });


    // check if $('#Image-Maps-Com-process-map') exists
    $(document).mousemove(function(e) {
      if ($('#Image-Maps-Com-process-map').length == 0) return;
      var mouseX = e.pageX - $('#Image-Maps-Com-process-map').offset().left;
      var mouseY = e.pageY - $('#Image-Maps-Com-process-map').offset().top - 5;
      $('.tooltip').css({
        'top': mouseY,
        'left': mouseX
      }).fadeIn('slow');
    });

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
