<div id="masterlist">
  {!! Form::open(['method' => 'GET']) !!}
  <fieldset class="masterlist-search-grid form-inline flex ji-start ai-end my-2">
    <legend>Character Search</legend>
    <div class="character-name form-group grid ji-start m-0 w-100">
      {!! Form::label('name', ucfirst(__('lorekeeper.character')) . ' Name/Code: ', ['class' => 'mr-2']) !!}
      {!! Form::text('name', Request::get('name'), ['class' => 'w-100 form-control']) !!}
    </div>
    {{-- <div class="species form-group  m-0">
      {!! Form::select('rarity_id', $rarities, Request::get('rarity_id'), ['class' => 'form-control mr-2']) !!}
    </div> --}}
    <div class="species form-group w-100 m-0">
      {!! Form::label('species_id', 'Species: ') !!}
      {!! Form::select('species_id', $specieses, Request::get('species_id'), ['class' => 'form-control w-100']) !!}
    </div>
    <div class="sortby form-inline ji-start mb-0 w-100">
      <div class="form-group mb-0 w-100">
        {!! Form::label('sort', 'Sort: ', ['class' => 'jiform-inline label-start w-100']) !!}
        @if (!$isMyo)
          {!! Form::select(
              'sort',
              [
                  'number_desc' => 'Number Descending',
                  'number_asc' => 'Number Ascending',
                  'id_desc' => 'Newest First',
                  'id_asc' => 'Oldest First',
                  'sale_value_desc' => 'Highest Sale Value',
                  'sale_value_asc' => 'Lowest Sale Value'
              ],
              Request::get('sort'),
              ['class' => 'form-control w-100']
          ) !!}
        @else
          {!! Form::select(
              'sort',
              [
                  'id_desc' => 'Newest First',
                  'id_asc' => 'Oldest First',
                  'sale_value_desc' => 'Highest Sale Value',
                  'sale_value_asc' => 'Lowest Sale Value'
              ],
              Request::get('sort'),
              ['class' => 'form-control w-100']
          ) !!}
        @endif
      </div>
    </div>
    {!! Form::submit('Search', ['class' => 'searchbutton btn btn-primary as-end js-center']) !!}
    <div class="advanced-search-toggle mb-0 as-end js-center">
      <a
        href="#advancedSearch"
        class="btn btn-sm btn-secondary"
        data-bs-toggle="collapse"
      > Advanced <i class="fas fa-caret-down"></i></a>
    </div>
  </fieldset>
  <div class="card bg-light mb-0 collapse" id="advancedSearch">

    @include('browse._masterlist_advanced_search')

    {!! Form::submit('Search', ['class' => ' searchbutton btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
  <hr class="my-4">

</div>
<div class="hide" id="featureContent">
  <div class="feature-block col-md-4 col-sm-6 mt-3 p-1">
    <div class="card">
      <div class="card-body d-flex">
        {!! Form::select('feature_id[]', $features, null, [
            'class' => 'form-control feature-select selectize',
            'placeholder' => 'Select Trait'
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
data-bs-toggle="tooltip"
title="Grid View"
alt="Grid View"
  ><i class="fas fa-th"></i></button>
  <button
type="button"
class="btn btn-secondary list-view-button"
data-bs-toggle="tooltip"
title="List View"
alt="List View"
  ><i class="fas fa-bars"></i></button>
</div>
  </div> --}}
{!! $characters->render() !!}
<div id="ml-gridView" class="">
  {{-- {{ dd($characters) }} --}}
  @foreach ($characters as $character)
    @include('browse._masterlist_content_entry', [
        'char_image' =>
            $character->image->canViewFull(Auth::user() ?? null) && file_exists(public_path($character->image->imageDirectory . ' /
            ' . $character->image->fullsizeFileName)) ? $character->image->thumbnailUrl : $character->image->thumbnailUrl
    ])
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
