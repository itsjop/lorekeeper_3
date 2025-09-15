<script>
  $(document).on('focusin', function(e) {
    if ($(e.target).closest(
        ".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
      e.stopImmediatePropagation();
    }
  });
  $(function() {

    $('.cp').colorpicker();
    $('[data-bs-toggle="tooltip"]').tooltip({
      html: true
    });

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

    $('#mobile-sidebar-toggle').on('click', (e) => {
      e.preventDefault();
      $('#sidebar-container').toggleClass('show')
    })

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

    // function setRows(el) {
    //   let size = '0fr ';
    //   let open = el.hasAttribute("data-open");
    //   if (open) {
    //     size = '1fr ';
    //   }
    //   let styl = 'auto ';
    //   for (let i = 1; i < el.childElementCount - 1; i++) { // shows 0, then 1, then 2
    //     if (open) {
    //       if (el.children[i].tagName === 'HR') {
    //         console.log('open', open, size)
    //         styl += '3px ';
    //       } else {
    //         console.log('open', open, size)
    //         styl += size;
    //       }
    //     }
    //   }
    //   el.style.gridTemplateRows = styl;
    // }
    // document.querySelectorAll('.details-sb').forEach(detail => {
    //   // setRows(detail);
    //   let summary = detail.querySelector(":scope > summary");
    //   summary.addEventListener('click', () => {
    //     detail.toggleAttribute("data-open");
    //     // setRows(detail);
    //   });
    // });
    applyLocalSettings();
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


  function applyLocalSettings() {
    let siteTheme = localStorage.getItem("som_siteTheme");
    let backdropBlur = localStorage.getItem("som_backdropBlur") === 'true';
    let animations = localStorage.getItem("som_animations") === 'true';
    let hoverEffects = localStorage.getItem("som_effects");
    let newSettings = `
    ${siteTheme ? '' : ''}
    ${backdropBlur ? '--var_backdrop-saturate: 200% ; --var_backdrop-blur: 5px;' : '--var_backdrop-saturate: 100% ; --var_backdrop-blur: 0px;'}
    ${animations ? '--var_animation_time: 1000s' : '--var_animation_time: 0s'}
    ${hoverEffects === 'default' ? ''
      : hoverEffects === 'reduced' ? '--var_transition_time: .3s; --var_transition_timing: linear;'
      : hoverEffects === 'instant' ? '--var_transition_time: 0s; --var_transition_timing: linear;'
      : ''
    }
    `;
    let ap = document.getElementById('app');
    ap.classList.remove(siteTheme === 'dark' ? 'light' : 'dark');
    ap.classList.add(siteTheme);
    ap.style.cssText = newSettings;
    console.log("newSettings", newSettings);
  }
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
