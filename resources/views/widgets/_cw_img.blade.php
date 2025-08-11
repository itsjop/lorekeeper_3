{{-- <div id="ctn-{{ $id }}" class="cw-img show">
  <img id="img-{{ $id }}" src="{{ asset($src) }}" alt="Image depicting {{ $warning }}" /> --}}
<div id="normal-ctn" class="cw-img">
  <img id="normal-img" src="{{ asset($src) }}" alt="Image depicting {{ $warning }}" />
  <div class="warning">
    <button id="normal-btn" class="btn btn-primary" type="button" aria-expanded="false" aria-controls="normal-ctn">
      Button to show thing
    </button>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#normal-btn').on('click', function(e) {
      e.preventDefault();
      $('#normal-ctn').toggleClass('hidden');
      stopPropagation();
    });
  })
</script>
