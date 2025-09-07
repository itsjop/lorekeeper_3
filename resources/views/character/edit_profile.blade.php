@extends('character.layout', ['componentName' => 'character/edit-profile', 'isMyo' => $character->is_myo_slot])

@section('profile-title')
  Editing {{ $character->fullName }}'s Profile
@endsection

@section('meta-img')
  {{ $character->image->content_warnings ? asset('images/somnivores/site/content-warning.png') : $character->image->thumbnailUrl }}
@endsection

@section('profile-content')

  @if ($character->is_myo_slot)
    {!! breadcrumbs([
        'MYO Slot Masterlist' => 'myos',
        $character->fullName => $character->url,
        'Editing Profile' => $character->url . '/profile/edit'
    ]) !!}
  @else
    {!! breadcrumbs([
        $character->category->masterlist_sub_id
            ? $character->category->sublist->name . ' Masterlist'
            : 'Character Masterlist' => $character->category->masterlist_sub_id
            ? 'sublist/' . $character->category->sublist->key
            : 'masterlist',
        $character->fullName => $character->url,
        'Editing Profile' => $character->url . '/profile/edit'
    ]) !!}
  @endif

  @include('character._header', ['character' => $character])

  @if ($character->user_id != Auth::user()->id)
    <div class="alert alert-warning">
      You are editing this character as a staff member.
    </div>
  @endif

  {!! Form::open(['url' => $character->url . '/profile/edit']) !!}
  @if (!$character->is_myo_slot)
    <div class="form-group">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', $character->name, ['class' => 'form-control']) !!}
    </div>
    @if (config('lorekeeper.extensions.character_TH_profile_link'))
      <div class="form-group">
        {!! Form::label('link', 'Profile Link') !!}
        {!! Form::text('link', $character->profile->link, ['class' => 'form-control']) !!}
      </div>
    @endif
    {!! Form::label('profession', 'Profession') !!} {!! add_help(
        'Select a profession from the available ones below! If nothing fits, you may write your own profession into the text field instead. Note that this will use a default icon.'
    ) !!}
    <div class="row">
      <div class="col-md form-group">
        {!! Form::select('profession_id', [0 => 'Choose a Profession'] + $professions, $character->profile->profession_id ?? 0, [
            'class' => 'form-control selectize'
        ]) !!}
      </div>
      <div class="col-md form-group">
        {!! Form::text('profession', $character->profile->profession, ['class' => 'form-control']) !!}
      </div>
    </div>
  @endif

  @if (!$character->is_myo_slot && ($char_enabled == 2 || (Auth::user()->isStaff && $char_enabled == 3)))
    @if (Auth::user()->isStaff && $char_enabled == 3)
      <div class="alert alert-warning">You can edit this because you are a staff member. Normal users cannot edit their character
        locations freely.</div>
    @endif
    <div class="form-group row">
      <label class="col-md-1 col-form-label">Location</label>
      <div class="col-md">
        {!! Form::select(
            'location',
            [0 => 'Choose a Location'] + $locations,
            isset($character->home_id) ? $character->home_id : 0,
            ['class' => 'form-control selectize']
        ) !!}
      </div>
    </div>
  @endif

  @if (!$character->is_myo_slot && ($char_faction_enabled == 2 || (Auth::user()->isStaff && $char_faction_enabled == 3)))
    @if (Auth::user()->isStaff && $char_faction_enabled == 3)
      <div class="alert alert-warning">You can edit this because you are a staff member. Normal users cannot edit their character
        factions freely.</div>
    @endif
    <p>Please note that changing this character's faction will remove them from any special ranks and reset their faction standing!
    </p>
    <div class="form-group row">
      <label class="col-md-1 col-form-label">Faction</label>
      <div class="col-md">
        {!! Form::select(
            'faction',
            [0 => 'Choose a Faction'] + $factions,
            isset($character->faction_id) ? $character->faction_id : 0,
            ['class' => 'form-control selectize']
        ) !!}
      </div>
    </div>
  @endif

  <div class="form-group">
    {!! Form::label('text', 'Profile Content') !!}
    {!! Form::textarea('text', $character->profile->text, ['class' => 'wysiwyg form-control']) !!}
  </div>
  @if ($character->user_id == Auth::user()->id)
    @if (!$character->is_myo_slot)
      <div class="row">
        <div class="col-md form-group">
          {!! Form::label('is_gift_art_allowed', 'Allow Gift Art', ['class' => 'form-check-label mb-3']) !!} {!! add_help(
              'This will place the character on the list of characters that can be drawn for gift art. This does not have any other functionality, but allow users looking for characters to draw to find your character easily.'
          ) !!}
          {!! Form::select('is_gift_art_allowed', [0 => 'No', 1 => 'Yes', 2 => 'Ask First'], $character->is_gift_art_allowed, [
              'class' => 'form-control user-select'
          ]) !!}
        </div>
        <div class="col-md form-group">
          {!! Form::label('is_gift_writing_allowed', 'Allow Gift Writing', ['class' => 'form-check-label mb-3']) !!} {!! add_help(
              'This will place the character on the list of characters that can be written about for gift writing. This does not have any other functionality, but allow users looking for characters to write about to find your character easily.'
          ) !!}
          {!! Form::select(
              'is_gift_writing_allowed',
              [0 => 'No', 1 => 'Yes', 2 => 'Ask First'],
              $character->is_gift_writing_allowed,
              ['class' => 'form-control user-select']
          ) !!}
        </div>
      </div>
    @endif
    @if ($character->is_tradeable || $character->is_sellable)
      <div class="form-group disabled">
        {!! Form::checkbox('is_trading', 1, $character->is_trading, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_trading', 'Up For Trade', ['class' => 'form-check-label ml-3']) !!} {!! add_help(
            'This will place the character on the list of characters that are currently up for trade. This does not have any other functionality, but allow users looking for trades to find your character easily.'
        ) !!}
      </div>
    @else
      <div class="alert alert-secondary">Cannot be set to "Up for Trade" as character cannot be traded or sold.</div>
    @endif
  @endif
  @if ($character->user_id != Auth::user()->id)
    <div class="form-group">
      {!! Form::checkbox('alert_user', 1, true, [
          'class' => 'form-check-input',
          'data-toggle' => 'toggle',
          'data-onstyle' => 'danger'
      ]) !!}
      {!! Form::label('alert_user', 'Notify User', ['class' => 'form-check-label ml-3']) !!} {!! add_help(
          'This will send a notification to the user that their character profile has been edited. A notification will not be sent if the character is not visible.'
      ) !!}
    </div>
  @endif
  <div class="text-right">
    {!! Form::submit('Edit Profile', ['class' => 'btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}

  <hr />

  <h5>Sort Character Titles</h5>
  <p>Here you can order your character's titles however you like! By default, the titles will be ordered by the same sorting as
    appears on the world page.</p>
  @if (!count($character->image->titles))
    <p>No titles found.</p>
  @else
    <table class="table table-sm title-table">
      <tbody id="sortable" class="sortable">
        @foreach ($character->image->titles()->orderByDesc('sort')->get() as $title)
          <tr class="sort-item" data-id="{{ $title->id }}">
            <td>
              <a class="fas fa-arrows-alt-v handle mr-3" href="#">
              </a>
              {!! $title->title ? $title->title->displayName : $title->data['full'] !!}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mb-4 float-right">
      {!! Form::open(['url' => $character->url . '/profile/titles/sort']) !!}
      {!! Form::hidden('sort', '', ['id' => 'sortableOrder']) !!}
      {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  @endif
@endsection
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
