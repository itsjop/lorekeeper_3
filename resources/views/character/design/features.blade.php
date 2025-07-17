@extends('character.design.layout', ['componentName' => 'character/design/features'])
@section('design-title')
  Design Approval Request (#{{ $request->id }}) :: Traits
@endsection

@section('design-content')
  {!! breadcrumbs([
      'Design Approvals' => 'designs',
      'Request (#' . $request->id . ')' => 'designs/' . $request->id,
      'Traits' => 'designs/' . $request->id . '/traits'
  ]) !!}

  @include('character.design._header', ['request' => $request])

  <div class="card mb-3">
    <div class="card-body br-ntl-15">
      <h2>
        Character Details</h2>

      @if ($request->status == 'Draft' && $request->user_id == Auth::user()->id)
        <p>Select the details and traits for the {{ $request->character->is_myo_slot ? 'created' : 'updated' }} character.
          @if ($request->character->is_myo_slot)
            {{-- Some traits may have been restricted for you - you cannot change them. --}}
          @endif
        </p>
        <hr>
        {!! Form::open(['url' => 'designs/' . $request->id . '/traits']) !!}
        <div class="form-group">
          <h3>{!! Form::label('species_id', ucfirst(__('lorekeeper.species'))) !!}</h3>
          @if ($request->character->is_myo_slot && $request->character->image->species_id)
            <div class="alert alert-secondary">{!! $request->character->image->species->displayName !!}</div>
          @else
            {!! Form::select('species_id', $specieses, $request->species_id, ['class' => 'form-control', 'id' => 'species']) !!}
          @endif
        </div>
        <hr>
        <div class="form-group">
          <h3>{!! Form::label('subtype_id', ucfirst(__('lorekeeper.subtype'))) !!}</h3>
          <p>
            {{ $request->character->is_myo_slot
                ? 'By default, you may only select from the 6 Pure Palates (Sweet, Dreadful, Mundane, Energetic, Strange, or Passionate). For your character to have a Dual Palate, you must attach a "Dual Essence Enchantment" to your request in the add-ons tab.'
                : 'You cannot change your character’s palate without attaching a Palate Attunement or Dual Essence Enchantment in the add-ons tab. Otherwise, do not change the selected subtype.' }}

          </p>
          @if ($request->character->is_myo_slot && $request->character->image->subtype_id)
            <div class="p-2 rounded border">{!! $request->character->image->subtype->displayName !!}</div>
          @else
            {{-- TODO: SUBTYPES make this only select one --}}
            <div id="subtypes">
              {!! Form::select('subtype_id', $subtypes, $request->subtype_id, ['class' => 'form-control', 'id' => 'subtype']) !!}
            </div>
          @endif
        </div>

        <hr>
        {{-- <h5>{{ ucfirst(__('transformations.transformations')) }}</h5> --}}
        <div class="form-group">
          <h3>{!! Form::label('transformation_id', 'Masterlist Image Type') !!}</h3>
          <p>Specify the type of image you have uploaded for your Request here.
            <br>For more information about Masterlist Image Types, visit the MYO Submission Guide!
          </p>
          </p>
          @if ($request->character->is_myo_slot && $request->character->image->transformation_id)
            <div class="alert alert-secondary">{!! $request->character->image->transformation->displayName !!}</div>
          @else
            <div id="transformations">
              {!! Form::select('transformation_id', $transformations, safe($request->transformation_id), [
                  'class' => 'form-control',
                  'id' => 'transformation'
              ]) !!}
            </div>
          @endif
          {{-- </div>
        <div class="form-group">
          {!! Form::label(ucfirst(__('transformations.transformation')) . ' Tab Info (Optional)') !!}{!! add_help(
              'This is text that will show alongside the ' .
                  __('transformations.transformation') .
                  ' name in the tabs, so try to keep it short.'
          ) !!}
          {!! Form::text('transformation_info', $request->transformation_info, [
              'class' => 'form-control mr-2',
              'placeholder' => 'Tab Info (Optional)'
          ]) !!}
        </div>
        <div class="form-group">
          {!! Form::label(ucfirst(__('transformations.transformation')) . ' Origin/Lore (Optional)') !!}{!! add_help(
              'This is text that will show alongside the ' .
                  __('transformations.transformation') .
                  ' name on the image info area. Explains why the character takes this form, how, etc. Should be pretty short.'
          ) !!}
          {!! Form::text('transformation_description', $request->transformation_description, [
              'class' => 'form-control mr-2',
              'placeholder' => 'Origin Info (Optional)'
          ]) !!}
        </div> --}}

          {{-- <div class="form-group">
          <h3>{!! Form::label('rarity_id', 'Character Rarity') !!}</h3>
          @if ($request->character->is_myo_slot && $request->character->image->rarity_id)
            <div class="alert alert-secondary">{!! $request->character->image->rarity->displayName !!}</div>
          @else
            {!! Form::select('rarity_id', $rarities, $request->rarity_id, ['class' => 'form-control', 'id' => 'rarity']) !!}
          @endif
        </div> --}}

          <hr>
          <div class="form-group">
            <h3>{!! Form::label('Traits') !!}</h3>
            @if (Settings::get('trait_per_item') == 0 && count($request->getAttachedTraitIds()) > 0)
              <div>
                <a
                  href="#"
                  class="btn btn-primary mb-2"
                  id="add-feature"
                >Add Trait</a>
              </div>
            @else
              <p>Staff is not able to modify traits during the submission process, so be sure to open a design check in our Discord
                help channel
                if you have any questions regarding which traits your design may need!</p>
              <p>Common/Default traits do not need to be added. Staff with update your character with them after the submission has
                been approved.</p>
              <p><b><i>You must attach a trait item in order to choose new traits for your character.</i></b></p>
            @endif
            <div id="featureList">
              {{-- Add in the compulsory traits for MYO slots --}}
              @if ($request->character->is_myo_slot && $request->character->image->features)
                @foreach ($request->character->image->features as $feature)
                  <div class="mb-2 d-flex align-items-center">
                    {!! Form::text('', $feature->name, ['class' => 'form-control mr-2', 'disabled']) !!}
                    {!! Form::text('', $feature->data, ['class' => 'form-control mr-2', 'disabled']) !!}
                    <div>{!! add_help('This trait is required.') !!}</div>
                  </div>
                @endforeach
              @endif
              <hr>
              {{-- Add in the ones that currently exist --}}
              @if ($request->features)
                @foreach ($request->features as $feature)
                  <div class="mb-2 d-flex">
                    {!! Form::select('feature_id[]', $features, $feature->feature_id, [
                        'class' => 'form-control mr-2 feature-select',
                        'placeholder' => 'Select Trait'
                    ]) !!}
                    {!! Form::text('feature_data[]', $feature->data, [
                        'class' => 'form-control mr-2',
                        'placeholder' => 'Extra Info (Optional)'
                    ]) !!}

                    @if ($request->canRemoveTrait() || Settings::get('trait_remover_needed') == 0)
                      <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
                    @endif
                  </div>
                @endforeach
              @endif
              @if (count($itemFeatures) > 0)
                @foreach ($itemFeatures as $itemFeature)
                  <div class="mb-2 d-flex">
                    <!--- These selects are built based on the trait item added and only allow the specified traits to be chosen! --->
                    {!! Form::select('feature_id[]', $itemFeature, array_key_first($itemFeature), [
                        'class' => 'form-control mr-2 feature-select'
                    ]) !!}
                    {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}

                  </div>
                @endforeach
              @endif
            </div>
            <div class="feature-row hide mb-2">
              {!! Form::select('feature_id[]', $request->character->myo_type != 'regular' ? $features : $choiceFeatures, null, [
                  'class' => 'form-control mr-2 feature-select',
                  'placeholder' => 'Select Trait'
              ]) !!}
              {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
              <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
            </div>
            <div class="text-right">
              {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
          @else
            <div class="mb-1">
              <div class="row">
                <div class="col-md-2 col-4">
                  <h5>{{ ucfirst(__('lorekeeper.species')) }}</h5>
                </div>
                <div class="col-md-10 col-8">{!! $request->species ? $request->species->displayName : 'None Selected' !!}</div>
              </div>
              @if ($request->subtype_id)
                <div class="row">
                  <div class="col-md-2 col-4">
                    <h5>{{ ucfirst(__('lorekeeper.subtype')) }}</h5>
                  </div>
                  <div class="col-md-10 col-8">
                    {!! $request->subtype_id ? $request->subtype->displayName : 'None' !!}
                  </div>
                </div>
              @endif
              @if ($request->transformation_id)
                <div class="row">
                  <div class="col-md-2 col-4">
                    <h5>{{ ucfirst(__('transformations.transformation')) }}</h5>
                  </div>
                  <div class="col-md-10 col-8">
                    @if ($request->character->is_myo_slot && $request->character->image->transformation_id)
                      {!! $request->character->image->transformation->displayName !!}
                    @else
                      {!! $request->transformation_id ? $request->transformation->displayName : 'None Selected' !!}
                    @endif
                  </div>
                  <div class="col-md-2 col-4">
                    <strong>Tab Info</strong>
                  </div>
                  <div class="col-md-10 col-8">
                    @if ($request->character->is_myo_slot && $request->character->image->transformation_info)
                      {{ $request->character->image->transformation_info }}
                    @else
                      {!! $request->transformation_info ? $request->transformation_info : 'No tab info given.' !!}
                    @endif
                  </div>
                  <div class="col-md-2 col-4">
                    <strong>Description</strong>
                  </div>
                  <div class="col-md-10 col-8">
                    @if ($request->character->is_myo_slot && $request->character->image->transformation_description)
                      {{ $request->character->image->transformation_description }}
                    @else
                      {!! $request->transformation_description ? $request->transformation_description : 'No description given.' !!}
                    @endif
                  </div>
                </div>
              @endif
              <div class="row">
                <div class="col-md-2 col-4">
                  <h5>Rarity</h5>
                </div>
                <div class="col-md-10 col-8">{!! $request->rarity ? $request->rarity->displayName : 'None Selected' !!}</div>
              </div>
            </div>
            <h5>Traits</h5>
            <div>
              @if ($request->character && $request->character->is_myo_slot && $request->character->image->features)
                @foreach ($request->character->image->features as $feature)
                  <div>
                    @if ($feature->feature->feature_category_id)
                      <strong>{!! $feature->feature->category->displayName !!}:</strong>
                      @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                        ({{ $feature->data }})
                      @endif <span class="text-danger">*Required</span>
                  </div>
                @endforeach
              @endif
              @foreach ($request->features as $feature)
                <div>
                  @if ($feature->feature->feature_category_id)
                    <strong>{!! $feature->feature->category->displayName !!}:</strong>
                    @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                      ({{ $feature->data }})
                    @endif
                </div>
              @endforeach
            </div>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  @include('widgets._image_upload_js')
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
    });

    $("#species").change(function() {
      var species = $('#species').val();
      var id = '<?php echo $request->id; ?>';
      $.ajax({
        type: "GET",
        url: "{{ url('designs/traits/subtype') }}?species=" + species + "&id=" + id,
        dataType: "text"
      }).done(function(res) {
        $("#subtypes").html(res);
      }).fail(function(jqXHR, textStatus, errorThrown) {
        alert("AJAX call failed: " + textStatus + ", " + errorThrown);
      });
      $.ajax({
        type: "GET",
        url: "{{ url('designs/traits/transformation') }}?species=" + species + "&id=" + id,
        dataType: "text"
      }).done(function(res) {
        $("#transformations").html(res);
      }).fail(function(jqXHR, textStatus, errorThrown) {
        alert("AJAX call failed: " + textStatus + ", " + errorThrown);
      });
    });
  </script>
@endsection
