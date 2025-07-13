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
      plugins: 'advlist autolink print spoiler paste lists link image charmap preview anchor code fullscreen insertdatetime media table code help wordcount',
      toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
      content_css: [
        '{{ asset('css/vendor/lorekeeper.css') }}'
      ],
      spoiler_caption: 'Toggle Spoiler',
      target_list: false
    });

    // function closeMenuOnBodyClick(event) {
    //   // get the event path
    //   const path = event.composedPath();
    //   // check if it has the menu element
    //   if (path.some((elem) => ['site-navbar', 'site-navbar-auth'].includes(elem.id))) {
    //     // terminate this function if it does
    //     return;
    //   }
    //   closeMenu();
    // }

    // $('#header-nav .navbar-toggler').on("click", () => {
    //   $('#navbarSupportedContent').toggleClass('show')
    // })

    // // Menu handling
    // function openMenu(dd) {
    //   unShowAllDropdownsExcept();
    //   showDropdown(dd);
    //   document.documentElement.addEventListener('click', closeMenuOnBodyClick);
    //   // console.log('opened and added body')
    // }

    // function closeMenu(dd = null) {
    //   unShowAllDropdownsExcept();
    //   document.documentElement.removeEventListener('click', closeMenuOnBodyClick);
    //   // console.log('closed and removed body')
    // }

    // function showDropdown(dd) {
    //   dd.classList.toggle('show');
    //   dd.querySelector(".dropdown-menu").classList.toggle('show');
    //   // console.log('shown')
    // }

    // function unShowAllDropdownsExcept(dropdown) {
    //   document.querySelectorAll("#navbarSupportedContent .dropdown").forEach(dd => {
    //     if (dropdown === null || dropdown?.isSameNode(dd)) return;
    //     dd.classList.remove('show');
    //     dd.querySelector(".dropdown-menu").classList.remove('show');
    //   })
    //   // console.log('closed all')
    // };

    // document.querySelectorAll("#navbarSupportedContent .dropdown").forEach(dropdown => {
    //   // console.log('dropdown listener', dropdown)
    //   dropdown.addEventListener('click', () => openMenu(dropdown));
    // });




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

  // if ($('.tooltip-bot, .tooltip-bot a, .nav-social-links a')) {
  //   $('.tooltip-bot, .tooltip-bot a, .nav-social-links a').tooltip({
  //     placement: "top"
  //   });
  // }
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
