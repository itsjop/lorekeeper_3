<h2>
  {{ $character->fullName }}'s Connections
  <a class="float-right mr-2" href="{{ url('reports/new?url=') . $character->url . '/links' }}">
    <i
      class="fas fa-exclamation-triangle text-danger"
      data-bs-toggle="tooltip"
      title="Click here to report this character's connections."
      style="opacity: 50%;"
    ></i>
  </a>
</h2>
@if (count($character->links))
  <div id="sortable" class="relationship sortable container  mt-4">
    @foreach ($character->links as $link)
      <div class="sort-item my-5" data-id="{{ $link->id }}">
        <a class="fas fa-arrows-alt-v handle mr-3" href="#"></a>

        <div class="character-imgs text-center mb-2 justify-content-center">
          @include('character._link_character', [
              'character' => $character,
              'charType' => 'primary'
          ])
          @include('character._link_character', [
              'character' => $link->getOtherCharacter($character->id),
              'charType' => 'secondary'
          ])
        </div>

        <fieldset class="">
          <legend class="legend-center ta-center">
            Relationship Status:
            <br>
            <strong>{{ $link->type }}</strong>
          </legend>
          <div class="relationship-content grid gap-1">
            <fieldset class="ours card-basic noborder">
              <legend class="legend-left"> {{ $character->name }}'s Feelings: </legend>
              @if (Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
                <div class="form-group">
                  {!! Form::label('type', 'Relationship Type') !!} {!! add_help('What type of relationship do these characters have?') !!}
                  {!! Form::select('type', $types, $link->type, ['class' => 'form-control mt-2', 'placeholder' => 'Relationship Type']) !!}
                </div>
                {!! Form::open(['url' => $character->url . '/links/info/' . $link->id]) !!}
                <div class="form-group">
                  {!! Form::textarea('info', $link->getRelationshipInfo($character->id) ?? null, [
                      'placeholder' => 'What are your characters feelings?',
                      'class' => 'form-control mb-2',
                      'cols' => 20,
                      'rows' => 8
                  ]) !!}
                </div>

                <div class="text-right m-2">
                  {!! Form::button('<i class="fas fa-cog"></i> Edit Info', ['class' => 'btn btn-outline-info btn-sm', 'type' => 'submit']) !!}

                  @if (Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
                    <div class="btn btn-danger btn-sm m-1 delete-button" data-id="{{ $link->id }}">
                      <i class="fas fa-trash"></i>
                    </div>
                  @endif
                </div>
                {!! Form::close() !!}
              @else
                <div class="m-4"> {{ $link->getRelationshipInfo($character->id) }} </div>
              @endif
            </fieldset>

            <fieldset class="theirs card-basic noborder">
              <legend class="legend-right"> {{ $link->getOtherCharacter($character->id)->name }}'s Feelings: </legend>
              <div class="">
                {{ $link->getRelationshipInfo($link->getOtherCharacter($character->id)->id) }}
              </div>
            </fieldset>
          </div>
        </fieldset>
      </div>
    @endforeach
  </div>

  @section('scripts')
    @parent
    <script>
      $(document).ready(function() {
        $('.handle').on('click', function(e) {
          e.preventDefault();
        });
        $("#sortable").sortable({
          items: '.sort-item',
          handle: ".handle",
          placeholder: "sortable-placeholder",
          stop: function(event, ui) {
            $('#sortableOrder').val($(this).sortable("toArray", {
              attribute: "data-id"
            }));
          },
          create: function() {
            $('#sortableOrder').val($(this).sortable("toArray", {
              attribute: "data-id"
            }));
          }
        });
        $("#sortable").disableSelection();
      });
    </script>
  @endsection
@else
  <div class="alert alert-info">
    <i class="fas fa-info-circle"></i> This character currently has no connections.
  </div>
@endif
