<div class="card-body masterlist-advanced-search">
  @if (!$isMyo)
    <div class="masterlist-search-field">
      {!! Form::label('character_category_id', 'Category: ') !!}
      {!! Form::select('character_category_id', $categories, Request::get('character_category_id'), [
          'class' => 'form-control mr-2',
          'style' => 'width: 250px'
      ]) !!}
    </div>

    <div class="masterlist-search-field">
      {!! Form::label('species_id', 'Species: ') !!}
      {!! Form::select('species_id', $specieses, Request::get('species_id'), ['class' => 'form-control w-100']) !!}
    </div>
    {{-- <div class="masterlist-search-field">
      {!! Form::label('subtype_id', ucfirst(__('lorekeeper.species')) . ' ' . ucfirst(__('lorekeeper.subtype')) . ':') !!}
      {!! Form::select('subtype_id', $subtypes, Request::get('subtype_id'), [
          'class' => 'form-control mr-2',
          'style' => 'width: 250px'
      ]) !!}
    </div> --}}
    <div class="masterlist-search-field">
      {!! Form::label('transformation_id', ucfirst(__('transformations.transformation')) . ': ') !!}
      {!! Form::select('transformation_id', $transformations, Request::get('transformation_id'), ['class' => 'form-control']) !!}
    </div>
    <div class="masterlist-search-field">
      {!! Form::label('has_transformation', 'Has a ' . ucfirst(__('transformations.transformation')) . ': ') !!}
      {!! Form::select(
          'has_transformation',
          ['1' => 'Has a ' . __('transformations.transformation') . '.'],
          Request::get('has_transformation'),
          ['class' => 'form-control', 'placeholder' => 'Any']
      ) !!}
    </div>
    <div class="masterlist-search-field">
      {!! Form::label('title_id', 'Title: ') !!}
      {!! Form::select('title_id', $titles, Request::get('title_id'), [
          'class' => 'form-control',
          'id' => 'customTitle',
          'style' => 'width: 250px'
      ]) !!}
    </div>
    <div class="masterlist-search-field" id="customTitleOptions">
      {!! Form::label('title_data', 'Custom Title: ') !!}
      {!! Form::text('title_data', Request::get('title_data'), ['class' => 'form-control', 'style' => 'width: 250px']) !!}
    </div>
    <hr />
  @endif
  <div class="masterlist-search-field">
    {!! Form::label('owner', 'Owner Username: ') !!}
    {!! Form::select('owner', $userOptions, Request::get('owner'), [
        'class' => 'form-control mr-2 userselectize',
        'style' => 'width: 250px',
        'placeholder' => 'Select a User'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::label('artist', 'Artist: ') !!}
    {!! Form::select('artist', $userOptions, Request::get('artist'), [
        'class' => 'form-control mr-2 userselectize',
        'style' => 'width: 250px',
        'placeholder' => 'Select a User'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::label('designer', 'Designer: ') !!}
    {!! Form::select('designer', $userOptions, Request::get('designer'), [
        'class' => 'form-control mr-2 userselectize',
        'style' => 'width: 250px',
        'placeholder' => 'Select a User'
    ]) !!}
  </div>
  <hr />
  <div class="masterlist-search-field">
    {!! Form::label('owner_url', 'Owner URL / Username: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
    {!! Form::text('owner_url', Request::get('owner_url'), [
        'class' => 'form-control mr-2',
        'style' => 'width: 250px',
        'placeholder' => 'Type a Username'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::label('artist_url', 'Artist URL / Username: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
    {!! Form::text('artist_url', Request::get('artist_url'), [
        'class' => 'form-control mr-2',
        'style' => 'width: 250px',
        'placeholder' => 'Type a Username'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::label('designer_url', 'Designer URL / Username: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
    {!! Form::text('designer_url', Request::get('designer_url'), [
        'class' => 'form-control mr-2',
        'style' => 'width: 250px',
        'placeholder' => 'Type a Username'
    ]) !!}
  </div>
  <hr />
  <div class="masterlist-search-field">
    {!! Form::label('sale_value_min', 'Resale Minimum ($): ') !!}
    {!! Form::text('sale_value_min', Request::get('sale_value_min'), [
        'class' => 'form-control mr-2',
        'style' => 'width: 250px'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::label('sale_value_max', 'Resale Maximum ($): ') !!}
    {!! Form::text('sale_value_max', Request::get('sale_value_max'), [
        'class' => 'form-control mr-2',
        'style' => 'width: 250px'
    ]) !!}
  </div>
  @if (!$isMyo)
    <div class="masterlist-search-field">
      {!! Form::label('is_gift_art_allowed', 'Gift Art Status: ') !!}
      {!! Form::select(
          'is_gift_art_allowed',
          [0 => 'Any', 2 => 'Ask First', 1 => 'Yes', 3 => 'Yes OR Ask First'],
          Request::get('is_gift_art_allowed'),
          ['class' => 'form-control', 'style' => 'width: 250px']
      ) !!}
    </div>
    <div class="masterlist-search-field">
      {!! Form::label('is_gift_writing_allowed', 'Gift Writing Status: ') !!}
      {!! Form::select(
          'is_gift_writing_allowed',
          [0 => 'Any', 2 => 'Ask First', 1 => 'Yes', 3 => 'Yes OR Ask First'],
          Request::get('is_gift_writing_allowed'),
          ['class' => 'form-control', 'style' => 'width: 250px']
      ) !!}
    </div>
  @endif
  <br />
  {{-- Setting the width and height on the toggles as they don't seem to calculate correctly if the div is collapsed. --}}
  <div class="masterlist-search-field">
    {!! Form::checkbox('is_trading', 1, Request::get('is_trading'), [
        'class' => 'form-check-input',
        'data-toggle' => 'toggle',
        'data-on' => 'Open For Trade',
        'data-off' => 'Any Trading Status',
        'data-width' => '200',
        'data-height' => '46'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::checkbox('is_sellable', 1, Request::get('is_sellable'), [
        'class' => 'form-check-input',
        'data-toggle' => 'toggle',
        'data-on' => 'Can Be Sold',
        'data-off' => 'Any Sellable Status',
        'data-width' => '204',
        'data-height' => '46'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::checkbox('is_tradeable', 1, Request::get('is_tradeable'), [
        'class' => 'form-check-input',
        'data-toggle' => 'toggle',
        'data-on' => 'Can Be Traded',
        'data-off' => 'Any Tradeable Status',
        'data-width' => '220',
        'data-height' => '46'
    ]) !!}
  </div>
  <div class="masterlist-search-field">
    {!! Form::checkbox('is_giftable', 1, Request::get('is_giftable'), [
        'class' => 'form-check-input',
        'data-toggle' => 'toggle',
        'data-on' => 'Can Be Gifted',
        'data-off' => 'Any Giftable Status',
        'data-width' => '202',
        'data-height' => '46'
    ]) !!}
  </div>
  <hr />
  <a href="#" class="float-right btn btn-sm btn-outline-primary add-feature-button"> Add Trait </a>

  <div class="form-group">
    {!! Form::label('Has Traits: ') !!} {!! add_help('This will narrow the search to characters that have ALL of the selected traits at the same time.') !!}
    {!! Form::select('feature_ids[]', $features, Request::get('feature_ids'), [
        'class' => 'form-control feature-select userselectize',
        'placeholder' => 'Select Traits',
        'multiple'
    ]) !!}
  </div>
  <hr />
  <div class="masterlist-search-field">
    {!! Form::checkbox('search_images', 1, Request::get('search_images'), [
        'class' => 'form-check-input mr-3',
        'data-toggle' => 'toggle'
    ]) !!}
    <span class="ml-2">
      Include all {{ __('lorekeeper.character') }} images in search
      {!! add_help(
          'Each character can have multiple images for each updated version of the character, which captures the traits on that character at that point in time. By default the search will only search on the most up-to-date image, but this option will retrieve characters that match the criteria on older images - you may get results that are outdated.'
      ) !!}
    </span>
  </div>

</div>
