{!! Form::open(['url' => 'admin/character/image/' . $image->id . '/traits']) !!}
<div class="form-group">
  {!! Form::label(ucfirst(__('lorekeeper.species'))) !!}
  {!! Form::select('species_id', $specieses, $image->species_id, ['class' => 'form-control', 'id' => 'species']) !!}
</div>

{{-- TODO: SUBTYPES make this only select one --}}
<div class="form-group" id="subtypes">
  {!! Form::label(ucfirst(__('lorekeeper.subtype')) . ' (Optional)') !!}
  {!! Form::select('subtype_id', $subtypes, $image->subtype_id, ['class' => 'form-control', 'id' => 'subtype']) !!}
</div>

<div class="form-group">
  {!! Form::label(ucfirst(__('lorekeeper.character')) . ' Rarity') !!}
  {!! Form::select('rarity_id', $rarities, $image->rarity_id, ['class' => 'form-control']) !!}
</div>

<div class="row">
  <div class="col-md-6 pr-2">
    <div class="form-group">
      {!! Form::label('Character Titles') !!} {!! add_help('If a character has multiple titles, the title with the highest rarity / sort will display first.') !!}
      {!! Form::select('title_ids[]', $titles, $image->titleIds, [
          'class' => 'form-control',
          'multiple',
          'id' => 'charTitle',
          'placeholder' => 'Select Titles',
      ]) !!}
    </div>
  </div>
  {{-- <div class="col-md-6">
    <div class="form-group hide" id="titleOptions">
      {!! Form::label('Extra Info / Custom Title (Optional)') !!} {!! add_help(
          'If \'custom title\' is selected, this will be displayed as the title. If a preexisting title is selected, it will be displayed in addition to it. The short version is only used in the case of a custom title.'
      ) !!}
      <div id="titleData">
        @foreach ($image->titles as $title)
          <div class="d-flex mb-2">
            <div class="mb-0 title-name col-3 col-md-3 col-sm-12">{{ $title->title?->title ?? 'Custom Title' }}</div>
            {!! Form::text(
                'title_data[' . ($title->title_id ?? 'custom') . '][full]',
                isset($title->data['full']) ? $title->data['full'] : null,
                ['class' => 'form-control mr-2', 'placeholder' => 'Full Title']
            ) !!}
            @if (Settings::get('character_title_display') && $title->title_id == 'custom')
              {!! Form::text(
                  'title_data[' . ($title->title_id ?? 'custom') . '][short]',
                  isset($title->data['short']) ? $title->data['short'] : null,
                  ['class' => 'form-control mr-2', 'placeholder' => 'Short Title (Optional)']
              ) !!}
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div> --}}
</div>

<hr>
<h5>{{ ucfirst(__('transformations.transformations')) }}</h5>
<div class="form-group" id="transformations">
  {!! Form::label(ucfirst(__('transformations.transformation')) . ' (Optional)') !!}
  {!! Form::select('transformation_id', $transformations, $image->transformation_id, [
      'class' => 'form-control',
      'id' => 'transformation',
  ]) !!}
</div>
<div class="form-group">
  {!! Form::label(ucfirst(__('transformations.transformation')) . ' Tab Info (Optional)') !!}{!! add_help('This is text that will show alongside the ' . __('transformations.transformation') . ' name in the tabs, so try to keep it short.') !!}
  {!! Form::text('transformation_info', $image->transformation_info, [
      'class' => 'form-control mr-2',
      'placeholder' => 'Tab Info (Optional)',
  ]) !!}
</div>
<div class="form-group">
  {!! Form::label(ucfirst(__('transformations.transformation')) . ' Origin/Lore (Optional)') !!}{!! add_help('This is text that will show alongside the ' . __('transformations.transformation') . ' name on the image info area. Explains why the character takes this form, how, etc. Should be pretty short.') !!}
  {!! Form::text('transformation_description', $image->transformation_description, [
      'class' => 'form-control mr-2',
      'placeholder' => 'Origin Info (Optional)',
  ]) !!}
</div>
<hr>

{{-- <div class="form-group">
  {!! Form::label('Character Sex (Optional)') !!}
  {!! Form::select('sex', [null => 'Select Sex', 'Male' => 'Male', 'Female' => 'Female'], $image->sex, [
      'class' => 'form-control',
  ]) !!}
</div> --}}

<div class="form-group">
  {!! Form::label('Traits') !!}
  <div>
    <a href="#" class="btn btn-primary mb-2" id="add-feature">Add Trait</a>
  </div>
  <div id="featureList">
    @foreach ($image->features as $feature)
      <div class="d-flex mb-2">
        {!! Form::select('feature_id[]', $features, $feature->feature_id, [
            'class' => 'form-control mr-2 feature-select original',
            'placeholder' => 'Select Trait',
        ]) !!}
        {!! Form::text('feature_data[]', $feature->data, [
            'class' => 'form-control mr-2',
            'placeholder' => 'Extra Info (Optional)',
        ]) !!}
        <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
      </div>
    @endforeach
  </div>
  <div class="feature-row hide mb-2">
    {!! Form::select('feature_id[]', $features, null, [
        'class' => 'form-control mr-2 feature-select',
        'placeholder' => 'Select Trait',
    ]) !!}
    {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
    <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
  </div>
</div>

<div class="text-right">
  {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}

{{-- <div class="form-group title-data original hide d-flex">
  <div class="mb-0 title-name col-4 col-md-4 col-sm-12"></div>
  {!! Form::text('full', null, ['class' => 'form-control mr-2', 'placeholder' => 'Full Title']) !!}
  @if (Settings::get('character_title_display'))
    {!! Form::text('short', null, ['class' => 'form-control mr-2', 'placeholder' => 'Short Title (Optional)']) !!}
  @endif
</div> --}}

@include('widgets._character_titles_js')
<script>
  $(document).ready(function() {
    var $title = $('#charTitle');
    var $titleOptions = $('#titleOptions');
    var titleEntry = $title.val() != 0;
    updateTitleEntry(titleEntry);
    $title.on('change', function(e) {
      var titleEntry = $title.val() != 0;
      updateTitleEntry(titleEntry);
    });

    function updateTitleEntry($show) {
      if ($show) $titleOptions.removeClass('hide');
      else $titleOptions.addClass('hide');
    }

    @if (config('lorekeeper.extensions.organised_traits_dropdown'))
      $('.original.feature-select').selectize({
        render: {
          item: featureSelectedRender
        }
      });
    @else
      $('.original.feature-select').selectize();
    @endif
    $('#add-feature').on('click', function(e) {
      e.preventDefault();
      addFeatureRow();
    });
    $('.remove-feature').on('click', function(e) {
      e.preventDefault();
      removeFeatureRow($(this));
    })

    function addFeatureRow() {
      var $clone = $('.feature-row').clone();
      $('#featureList').append($clone);
      $clone.removeClass('hide feature-row');
      $clone.addClass('d-flex');
      $clone.find('.remove-feature').on('click', function(e) {
        e.preventDefault();
        removeFeatureRow($(this));
      })

      @if (config('lorekeeper.extensions.organised_traits_dropdown'))
        $clone.find('.feature-select').selectize({
          render: {
            item: featureSelectedRender
          }
        });
      @else
        $clone.find('.feature-select').selectize();
      @endif
    }

    function removeFeatureRow($trigger) {
      $trigger.parent().remove();
    }

    function featureSelectedRender(item, escape) {
      return '<div> <span > ' + escape(item["text"].trim()) + '(' + escape(item["optgroup"].trim()) + ')' +
        ' < /span></div > ';
    }
    refreshSubtype();
  });

  $("#species").change(function() {
    refreshSubtype();
  });

  function refreshSubtype() {
    var species = $('#species').val();
    var id = '<?php echo $image->id; ?>';
    $.ajax({
      type: "GET",
      url: "{{ url('admin/character/image/traits/subtype') }}?species=" + species + "&id=" + id,
      dataType: "text"
    }).done(function(res) {
      $("#subtypes").html(res);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert("AJAX call failed: " + textStatus + ", " + errorThrown);
    });
    $.ajax({
      type: "GET",
      url: "{{ url('admin/character/image/traits/transformation') }}?species=" + species + "&id=" + id,
      dataType: "text"
    }).done(function(res) {
      $("#transformations").html(res);
    }).fail(function(jqXHR, textStatus, errorThrown) {
      alert("AJAX call failed: " + textStatus + ", " + errorThrown);
    });

  };
</script>
