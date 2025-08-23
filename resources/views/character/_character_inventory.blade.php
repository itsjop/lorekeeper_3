<div id="sortable" class="row sortable">
  @foreach ($items as $stackItem)
      <?php
      $item = $stackItem->first();
      $canName = $item->can_name;
      $stackName = $item->pivot->pluck('stack_name', 'id')->toArray()[$item->pivot->id];
      $stackNameClean = htmlentities($stackName);
      ?>
    <div class="col-md-3 col-6 text-center mb-2" data-id="{{ $item->pivot->id }}">
      <a href="#" class="grid ji-center inventory-stack text-center img" data-id="{{ $item->pivot->id }}"
         data-name="{!! $canName && $stackName ? htmlentities($stackNameClean) . ' [' : null !!}{{ $character->name ? $character->name : $character->slug }}'s {{ $item->name }}{!! $canName && $stackName ? ']' : null !!}">
        <img class="img-thumbnail" style="display: block" src="{{ $item->imageUrl }}"
             alt="{{ $item->name }}" />
        {{ $item->name }} x{{ $stackItem->sum('pivot.count') }}
      </a>
    </div>
  @endforeach
</div>
{!! Form::open(['url' => 'character/' . $character->slug . '/inventory/sort']) !!}
{!! Form::hidden('sort', null, ['id' => 'sortableOrder']) !!}
{!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

@section('scripts')
  <script>
    let isDragging = false;
    $(document).ready(function() {
      $("#sortable").sortable({
        characters: '.sort-item',
        placeholder: "sortable-placeholder col-md-3 col-6",
        stop: function(event, ui) {
          $('#sortableOrder').val($(this).sortable("toArray", {
            attribute: "data-id"
          }));
          setTimeout(function() {
            isDragging = false;
          }, 50);
        },
        start: function(event, ui) {
          isDragging = true;
        },
        create: function() {
          $('#sortableOrder').val($(this).sortable("toArray", {
            attribute: "data-id"
          }));
        }
      });
      $("#sortable").disableSelection();

      function isTouch() {
        try {
          document.createEvent("TouchEvent");
          return true;
        } catch (e) {
          return false;
        }
      }

      if (isTouch()) {
        $('#sortable').children().each(function() {
          var $clone = $('.handle-clone').clone();
          $(this).append($clone);
          $clone.removeClass('hide handle-clone');
        });
        $("#sortable").sortable("option", "handle", ".mobile-handle");
      }

      $('.inventory-stack').on('click', function(e) {
        if (isDragging) {
          return false;
        }
        e.preventDefault();
        let $parent = $(this);
        loadModal("{{ url('items') }}/character/" + $parent.data('id'), $parent.data('name'));
      });
    });
  </script>
@endsection
