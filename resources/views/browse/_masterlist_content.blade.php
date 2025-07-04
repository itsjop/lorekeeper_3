<div id="masterlist">
  {!! Form::open(['method' => 'GET']) !!}
  <fieldset class="masterlist-search-grid form-inline flex ji-start ai-end">
    <legend>Character Search</legend>
    <div class="character-name form-group grid ji-start m-0">
      {!! Form::label('name', ucfirst(__('lorekeeper.character')) . ' Name/Code: ', ['class' => 'mr-2']) !!}
      {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
    </div>
    {{-- <div class="species form-group  m-0">
      {!! Form::select('rarity_id', $rarities, Request::get('rarity_id'), ['class' => 'form-control mr-2']) !!}
    </div> --}}
    <div class="species form-group m-0">
      {!! Form::select('species_id', $specieses, Request::get('species_id'), ['class' => 'form-control']) !!}
    </div>
    <div class="sortby form-inline ji-start mb-3">
      <div class="form-group mr-3">
        {!! Form::label('sort', 'Sort: ', ['class' => 'mr-2']) !!}
        @if (!$isMyo)
          {!! Form::select(
              'sort',
              [
                  'number_desc' => 'Number Descending',
                  'number_asc' => 'Number Ascending',
                  'id_desc' => 'Newest First',
                  'id_asc' => 'Oldest First',
                  'sale_value_desc' => 'Highest Sale Value',
                  'sale_value_asc' => 'Lowest Sale Value',
              ],
              Request::get('sort'),
              ['class' => 'form-control'],
          ) !!}
        @else
          {!! Form::select(
              'sort',
              [
                  'id_desc' => 'Newest First',
                  'id_asc' => 'Oldest First',
                  'sale_value_desc' => 'Highest Sale Value',
                  'sale_value_asc' => 'Lowest Sale Value',
              ],
              Request::get('sort'),
              ['class' => 'form-control'],
          ) !!}
        @endif
      </div>
    </div>
    <div class="advanced-search-toggle text-right mb-3">
      <a href="#advancedSearch" class="btn btn-sm btn-outline-info" data-toggle="collapse"> Advanced <i class="fas fa-caret-down"></i></a>
    </div>
    <div class="card bg-light mb-3 collapse" id="advancedSearch">
      <div class="card-body masterlist-advanced-search">
        @if (!$isMyo)
          <div class="masterlist-search-field">
            {!! Form::label('character_category_id', 'Category: ') !!}
            {!! Form::select('character_category_id', $categories, Request::get('character_category_id'), [
                'class' => 'form-control mr-2',
                'style' => 'width: 250px',
            ]) !!}
          </div>
          <div class="masterlist-search-field">
            {!! Form::label('subtype_id', ucfirst(__('lorekeeper.species')) . ' ' . ucfirst(__('lorekeeper.subtype')) . ':') !!}
            {!! Form::select('subtype_id', $subtypes, Request::get('subtype_id'), [
                'class' => 'form-control mr-2',
                'style' => 'width: 250px',
            ]) !!}
          </div>
          <div class="masterlist-search-field">
            {!! Form::label('transformation_id', ucfirst(__('transformations.transformation')) . ': ') !!}
            {!! Form::select('transformation_id', $transformations, Request::get('transformation_id'), ['class' => 'form-control']) !!}
          </div>
          <div class="masterlist-search-field">
            {!! Form::label('has_transformation', 'Has a ' . ucfirst(__('transformations.transformation')) . ': ') !!}
            {!! Form::select('has_transformation', ['1' => 'Has a ' . __('transformations.transformation') . '.'], Request::get('has_transformation'), ['class' => 'form-control', 'placeholder' => 'Any']) !!}
          </div>
          <div class="masterlist-search-field">
            {!! Form::label('title_id', 'Title: ') !!}
            {!! Form::select('title_id', $titles, Request::get('title_id'), [
                'class' => 'form-control',
                'id' => 'customTitle',
                'style' => 'width: 250px',
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
              'placeholder' => 'Select a User',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::label('artist', 'Artist: ') !!}
          {!! Form::select('artist', $userOptions, Request::get('artist'), [
              'class' => 'form-control mr-2 userselectize',
              'style' => 'width: 250px',
              'placeholder' => 'Select a User',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::label('designer', 'Designer: ') !!}
          {!! Form::select('designer', $userOptions, Request::get('designer'), [
              'class' => 'form-control mr-2 userselectize',
              'style' => 'width: 250px',
              'placeholder' => 'Select a User',
          ]) !!}
        </div>
        <hr />
        <div class="masterlist-search-field">
          {!! Form::label('owner_url', 'Owner URL / Username: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
          {!! Form::text('owner_url', Request::get('owner_url'), [
              'class' => 'form-control mr-2',
              'style' => 'width: 250px',
              'placeholder' => 'Type a Username',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::label('artist_url', 'Artist URL / Username: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
          {!! Form::text('artist_url', Request::get('artist_url'), [
              'class' => 'form-control mr-2',
              'style' => 'width: 250px',
              'placeholder' => 'Type a Username',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::label('designer_url', 'Designer URL / Username: ') !!} {!! add_help('Example: https://deviantart.com/username OR username') !!}
          {!! Form::text('designer_url', Request::get('designer_url'), [
              'class' => 'form-control mr-2',
              'style' => 'width: 250px',
              'placeholder' => 'Type a Username',
          ]) !!}
        </div>
        <hr />
        <div class="masterlist-search-field">
          {!! Form::label('sale_value_min', 'Resale Minimum ($): ') !!}
          {!! Form::text('sale_value_min', Request::get('sale_value_min'), [
              'class' => 'form-control mr-2',
              'style' => 'width: 250px',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::label('sale_value_max', 'Resale Maximum ($): ') !!}
          {!! Form::text('sale_value_max', Request::get('sale_value_max'), [
              'class' => 'form-control mr-2',
              'style' => 'width: 250px',
          ]) !!}
        </div>
        @if (!$isMyo)
          <div class="masterlist-search-field">
            {!! Form::label('is_gift_art_allowed', 'Gift Art Status: ') !!}
            {!! Form::select('is_gift_art_allowed', [0 => 'Any', 2 => 'Ask First', 1 => 'Yes', 3 => 'Yes OR Ask First'], Request::get('is_gift_art_allowed'), ['class' => 'form-control', 'style' => 'width: 250px']) !!}
          </div>
          <div class="masterlist-search-field">
            {!! Form::label('is_gift_writing_allowed', 'Gift Writing Status: ') !!}
            {!! Form::select('is_gift_writing_allowed', [0 => 'Any', 2 => 'Ask First', 1 => 'Yes', 3 => 'Yes OR Ask First'], Request::get('is_gift_writing_allowed'), ['class' => 'form-control', 'style' => 'width: 250px']) !!}
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
              'data-height' => '46',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::checkbox('is_sellable', 1, Request::get('is_sellable'), [
              'class' => 'form-check-input',
              'data-toggle' => 'toggle',
              'data-on' => 'Can Be Sold',
              'data-off' => 'Any Sellable Status',
              'data-width' => '204',
              'data-height' => '46',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::checkbox('is_tradeable', 1, Request::get('is_tradeable'), [
              'class' => 'form-check-input',
              'data-toggle' => 'toggle',
              'data-on' => 'Can Be Traded',
              'data-off' => 'Any Tradeable Status',
              'data-width' => '220',
              'data-height' => '46',
          ]) !!}
        </div>
        <div class="masterlist-search-field">
          {!! Form::checkbox('is_giftable', 1, Request::get('is_giftable'), [
              'class' => 'form-check-input',
              'data-toggle' => 'toggle',
              'data-on' => 'Can Be Gifted',
              'data-off' => 'Any Giftable Status',
              'data-width' => '202',
              'data-height' => '46',
          ]) !!}
        </div>
        <hr />
        <a href="#" class="float-right btn btn-sm btn-outline-primary add-feature-button">Add Trait</a>

        <div class="form-group">
          {!! Form::label('Has Traits: ') !!} {!! add_help('This will narrow the search to characters that have ALL of the selected traits at the same time.') !!}
          {!! Form::select('feature_ids[]', $features, Request::get('feature_ids'), [
              'class' => 'form-control feature-select userselectize',
              'placeholder' => 'Select Traits',
              'multiple',
          ]) !!}
        </div>
        <hr />
        <div class="masterlist-search-field">
          {!! Form::checkbox('search_images', 1, Request::get('search_images'), [
              'class' => 'form-check-input mr-3',
              'data-toggle' => 'toggle',
          ]) !!}
          <span class="ml-2">Include all {{ __('lorekeeper.character') }} images in search {!! add_help(
              'Each character can have multiple images for each updated version of the character, which captures the traits on that character at that point in time. By default the search will only search on the most up-to-date image, but this option will retrieve characters that match the criteria on older images - you may get results that are outdated.',
          ) !!}</span>
        </div>

      </div>

    </div>

    {!! Form::submit('Search', ['class' => ' searchbutton btn btn-primary']) !!}
  </fieldset>
  {!! Form::close() !!}
</div>
<div class="hide" id="featureContent">
  <div class="feature-block col-md-4 col-sm-6 mt-3 p-1">
    <div class="card">
      <div class="card-body d-flex">
        {!! Form::select('feature_id[]', $features, null, [
            'class' => 'form-control feature-select selectize',
            'placeholder' => 'Select Trait',
        ]) !!}
        <a href="#" class="btn feature-remove ml-2"><i class="fas fa-times"></i></a>
      </div>
    </div>
  </div>
</div>
{{-- <div class="text-right mb-3">
<div class="btn-group">
  <button
type="button"
class="btn btn-secondary active grid-view-button"
data-toggle="tooltip"
title="Grid View"
alt="Grid View"
  ><i class="fas fa-th"></i></button>
  <button
type="button"
class="btn btn-secondary list-view-button"
data-toggle="tooltip"
title="List View"
alt="List View"
  ><i class="fas fa-bars"></i></button>
</div>
  </div> --}}
{!! $characters->render() !!}
<div id="ml-gridView">
  @foreach ($characters->chunk(4) as $chunk)
    @foreach ($chunk as $character)
      {{-- {{ dd(json_encode($character)) }} --}}
      <div class="masterlist-character text-center">
        <div class="name">
          <a href="{{ $character->url }}" class="">
            @if (!$character->is_visible)
              <i class="fas fa-eye-slash"></i>
            @endif
            {!! $character->warnings !!}
            {{ Illuminate\Support\Str::limit($character->nameFallback, 20, $end = '...') }}
          </a>
        </div>
        <a class="thumbnail" href="{{ $character->url }}">
          <img src="{{ $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . '/' . $character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}"
            class="ml-thumbnail" alt="Thumbnail for {{ $character->nameFallback }}" /></a>
        {{-- <div class="mt-1">@include('widgets._object_block', ['object' => $character->image])</div> --}}
        {!! $character->image->species_id ? $character->image->species->displayName : 'No ' . ucfirst(__('lorekeeper.species')) !!}
        {{-- {!! $character->image->rarity_id ? $character->image->rarity->displayName : 'No Rarity' !!} --}}
        {!! $character->displayOwner !!}
        <div class="slug">
          {{ Illuminate\Support\Str::limit($character->slug, 20, $end = '...') }}
        </div>
        @if (count($character->image->content_warnings ?? []) && (!Auth::check() || (Auth::check() && Auth::user()->settings->content_warning_visibility < 2)))
          <p class="mb-0">
            <span class="text-danger mr-1"><strong>Character Warning:</strong></span>
            {{ implode(', ', $character->image->content_warnings) }}
          </p>
        @endif
      </div>
    @endforeach
  @endforeach
</div>
<div id="listView" class="hide">
  <table class="table table-sm">
    <thead>
      <tr>
        <th>Owner</th>
        <th>Name</th>
        <th>Rarity</th>
        <th>{{ ucfirst(__('lorekeeper.species')) }}</th>
        @if (Settings::get('character_title_display'))
          <th>Title</th>
        @endif
        <th>Created</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($characters as $character)
        <tr>
          <td>{!! $character->displayOwner !!}</td>
          <td>
            @if (!$character->is_visible)
              <i class="fas fa-eye-slash"></i>
            @endif {!! $character->displayName !!}
          </td>
          <td>{!! $character->image->rarity_id ? $character->image->rarity->displayName : 'None' !!}</td>
          <td>{!! $character->image->species_id ? $character->image->species->displayName : 'None' !!}</td>
          @if (Settings::get('character_title_display'))
            <td>{!! $character->image->hasTitle
                ? ($character->image->title_id
                    ? $character->image->title->displayNameShort
                    : (isset($character->image->title_data['short'])
                        ? nl2br(htmlentities($character->image->title_data['short']))
                        : nl2br(htmlentities($character->image->title_data['full']))))
                : 'None' !!}</td>
          @endif
          <td>{!! format_date($character->created_at) !!}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
{!! $characters->render() !!}

<div class="text-center mt-4 small text-muted">
  {{ $characters->total() }} result{{ $characters->total() == 1 ? '' : 's' }} found.
</div>
