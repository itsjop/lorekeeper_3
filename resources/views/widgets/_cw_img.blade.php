<?php $id = uniqid(); ?>
<div id="ctn-{{ $id }}" class="cw-img show">
  <img
    id="img-{{ $id }}"
    src="{{ asset($src) }}"
    alt="Image depicting {{ $warnings }}"
  />
  <div class="warning">
    <h2> Content Warning:</h2>
    <p> {{ $warnings }} </p>
    <button
      id="btn-{{ $id }}"
      class="btn btn-primary"
      type="button"
      aria-expanded="false"
      aria-controls="normal-ctn"
    >
      Show Content
    </button>
  </div>
</div>

<script>
  $(document).ready(function() {
    var id = {!! json_encode($id) !!};
    $(`#btn-${id}`).on('click', function(e) {
      console.log("id", id, $(`#btn-${id}`))
      e.preventDefault();
      $(`#ctn-${id}`).toggleClass('hidden');
      e.stopImmediatePropagation();
    });
  })
</script>
