@extends('account.layout', ['componentName' => 'account/settings'])

@section('account-title')
  Settings
@endsection

@section('account-content')
  {!! breadcrumbs(['My Account' => Auth::user()->url, 'Settings' => 'account/settings']) !!}

  <h1>Settings</h1>

  {{-- AVATAR  --}}
  <div class="row">
    <div class="card-full p-3 mb-2">
      <h3>Avatar</h3>
      @if (Auth::user()->isStaff)
        <div class="text-left">
          <div class="alert alert-warning">Please note a hard refresh may be required to see your updated avatar. Also please note
            that uploading a .gif will display a 500 error after; the upload should still work, however.</div>
        </div>
      @endif
      {!! Form::open(['url' => 'account/avatar', 'files' => true]) !!}
      <div class="card-full mb-3 hide" id="avatarCrop">
        <div class="card-body">
          <img
            src="#"
            id="cropper"
            class="hide"
            alt=""
          />
          {!! Form::hidden('x0', null, ['id' => 'cropX0']) !!}
          {!! Form::hidden('x1', null, ['id' => 'cropX1']) !!}
          {!! Form::hidden('y0', null, ['id' => 'cropY0']) !!}
          {!! Form::hidden('y1', null, ['id' => 'cropY1']) !!}
        </div>
        <div class="alert alert-info mx-3">
          <b>Note:</b> Cropping does not work on gifs.
        </div>
      </div>
      <div class="form-group row">
        {!! Form::label('avatar', 'Update', ['class' => 'col-md-2 col-form-label']) !!}
        <div class="col-md-10">
          {!! Form::file('avatar', ['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div>

    {{-- PROFILE HEADER --}}
    {{-- <div class="col-12">
      <div class="card-full p-3 mb-2">
        <h3>Profile Header Image</h3>
        {!! Form::open(['url' => 'account/profile_img', 'files' => true]) !!}
        <div class="form-group row">
          {!! Form::label('profile_img', 'Update', ['class' => 'col-md-2 col-form-label']) !!}
          <div class="col-md-10">
            {!! Form::file('profile_img', ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="text-right">
          {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div> --}}
  </div>

  {{-- YOUR PROFILE --}}
  <div class="card-full p-3 mb-2">
    <h3>Profile</h3>
    {!! Form::open(['url' => 'account/profile']) !!}
    <div class="form-group">
      {!! Form::label('pronouns', 'Preferred Pronouns') !!} {!! add_help(
          'Your preferred pronouns will be displayed in various places across the site. This field can be changed or removed at anytime.'
      ) !!}
      {!! Form::textarea('pronouns', Auth::user()->profile->pronouns, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('text', 'Profile Text') !!}
      {!! Form::textarea('text', Auth::user()->profile->text, ['class' => 'form-control wysiwyg']) !!}
    </div>
    <div class="text-right">
      {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>

  @if ($user_enabled == 1 || (Auth::user()->isStaff && $user_enabled == 2))
    <div class="card-full p-3 mb-2">
      <h3>Home Location <span class="text-muted">({{ ucfirst($location_interval) }})</span></h3>
      @if (Auth::user()->isStaff && $user_enabled == 2)
        <div class="alert alert-warning">You can edit this because you are a staff member. Normal users cannot edit their own
          locations freely.</div>
      @endif
      @if ($char_enabled == 1)
        <div class="alert alert-warning">Your characters will have the same home as you.</div>
      @endif
      @if (Auth::user()->canChangeLocation)
        {!! Form::open(['url' => 'account/location']) !!}
        <div class="form-group row">
          <label class="col-md-2 col-form-label">Location</label>
          <div class="col-md-9">
            {!! Form::select(
                'location',
                [0 => 'Choose a Location'] + $locations,
                isset(Auth::user()->home_id) ? Auth::user()->home_id : 0,
                ['class' => 'form-control selectize']
            ) !!}
          </div>
          <div class="col-md text-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
          </div>
        </div>
        {!! Form::close() !!}
      @else
        <div class="alert alert-warning">
          <strong>You can't change your location right now.</strong>
          You last changed it on {!! format_date(Auth::user()->home_changed, false) !!}.
          Home locations can be changed {{ $location_interval }}.
        </div>
      @endif
    </div>
  @endif

  {{-- BORDER CUSTOMIZATION --}}
  <div class="card-full p-3 mb-2">
    <h3>Update Border</h3>
    <p>Change your onsite border.</p>
    <p>Standard borders behave as normal. Variants may be different colors or even border styles than the main border. If your
      chosen main border has a "layer" associated with it, you can layer that image with one of its variant's borders.</p>
    <p>Variants supersede standard borders, and layers supersede variants.</p>
    {!! Form::open(['url' => 'account/border']) !!}
    <div class="row">
      <div class="col-md-6 form-group">
        {!! Form::label('Border') !!}
        {!! Form::select('border', $borders, Auth::user()->border_id, ['class' => 'form-control', 'id' => 'border']) !!}
      </div>
      <div class="col-md-6 form-group">
        {!! Form::label('Border Variant') !!}
        {!! Form::select('border_variant_id', $border_variants, Auth::user()->border_variant_id, [
            'class' => 'form-control',
            'id' => 'bordervariant'
        ]) !!}
      </div>
    </div>
    <div id="layers">
    </div>
    <div class="row">
      <div class="col-md-12">
        <br>
        <h4>Border Style</h4>
      </div>
      <div class="col-md-5">
        <h4 class="text-center w-100">Border Flip</h4>
        <div class="row">
          <div class="col-md-12 form-group flex j-c-around a-i-center">
            {!! Form::label('border_flip', 'Flip Border (Horizontally)', ['class' => 'form-check-label ml-3']) !!}
            {!! Form::checkbox('border_flip', 1, Auth::user()->settings->border_settings['border_flip'] ?? 0, [
                'class' => 'form-check-input',
                'data-toggle' => 'toggle'
            ]) !!}
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <h4 class="text-center">Your Borders</h4>
        <div class="card-full p-3 mb-2 image-info-box">
          @if ($default->count())
            <h4 class="mb-0">Default</h4>
            <hr class="mt-0">
            <div class="row">
              @foreach ($default as $border)
                <div class="col-md-3 col-6 text-center">
                  <div class="shop-image">
                    {!! $border->preview() !!}
                  </div>
                  <div class="shop-name mt-1 text-center">
                    <h5>{!! $border->displayName !!}</h5>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
          @if (Auth::user()->borders->count())
            <h4 class="mb-0">Unlocked</h4>
            <hr class="mt-0">
            <div class="row">
              @foreach (Auth::user()->borders as $border)
                <div class="col-md-3 col-6 text-center">
                  <div class="shop-image">
                    {!! $border->preview() !!}
                  </div>
                  <div class="shop-name mt-1 text-center">
                    <h5>{!! $border->displayName !!}</h5>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
          @if (Auth::user()->isStaff)
            @if ($admin->count())
              <h4 class="mb-0">Staff-Only</h4>
              <hr class="mt-0">
              <small>You can see these as a member of staff</small>
              <div class="row">
                @foreach ($admin as $border)
                  <div class="col-md-3 col-6 text-center">
                    <div class="shop-image">
                      {!! $border->preview() !!}
                    </div>
                    <div class="shop-name mt-1 text-center">
                      <h5>{!! $border->displayName !!}</h5>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          @endif
        </div>
        <div class="text-right mb-4">
        </div>
      </div>
      <div class="col-md-12 flex j-c-end a-i-center gap-2">
        <a href="{{ url(Auth::user()->url . '/border-logs') }}">View logs...</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary a-s-center']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
  {{-- CHANGE USERNAME --}}
  @if (config('lorekeeper.settings.allow_username_changes'))
    <div class="card-full p-3 mb-2">
      <h3>Change Username</h3>
      @if (config('lorekeeper.settings.username_change_cooldown'))
        <div class="alert alert-info">
          You can change your username once every {{ config('lorekeeper.settings.username_change_cooldown') }} days.
        </div>
        @if (Auth::user()->logs()->where('type', 'Username Change')->orderBy('created_at', 'desc')->first())
          <div class="alert alert-warning">
            You last changed your username on
            {{ Auth::user()->logs()->where('type', 'Username Change')->orderBy('created_at', 'desc')->first()->created_at->format('F jS, Y') }}.
            <br />
            <b>
              You will be able to change your username again on
              {{ Auth::user()->logs()->where('type', 'Username Change')->orderBy('created_at', 'desc')->first()->created_at->addDays(config('lorekeeper.settings.username_change_cooldown'))->format('F jS, Y') }}.
            </b>
          </div>
        @endif
      @endif
      {!! Form::open(['url' => 'account/username']) !!}
      <div class="form-group row">
        <label class="col-md-2 col-form-label">Username</label>
        <div class="col-md-10">
          {!! Form::text('username', Auth::user()->name, ['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  @endif
  {{-- YOUR FACTION --}}
  @if ($user_faction_enabled == 1 || (Auth::user()->isStaff && $user_faction_enabled == 2))
    <div class="card-full p-3 mb-2">
      <h3>Faction <span class="text-muted">({{ ucfirst($location_interval) }})</span></h3>
      @if (Auth::user()->isStaff && $user_faction_enabled == 2)
        <div class="alert alert-warning">You can edit this because you are a staff member. Normal users cannot edit their own
          faction freely.</div>
      @endif
      @if ($char_faction_enabled == 1)
        <div class="alert alert-warning">Your characters will have the same faction as you.</div>
      @endif
      @if (Auth::user()->canChangeFaction)
        <p>Please note that changing your faction will remove you from any special ranks and reset your faction standing!</p>
        {!! Form::open(['url' => 'account/faction']) !!}
        <div class="form-group row">
          <label class="col-md-2 col-form-label">Faction</label>
          <div class="col-md-9">
            {!! Form::select(
                'faction',
                [0 => 'Choose a Faction'] + $factions,
                isset(Auth::user()->faction_id) ? Auth::user()->faction_id : 0,
                ['class' => 'form-control selectize']
            ) !!}
          </div>
          <div class="col-md text-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
          </div>
        </div>
        {!! Form::close() !!}
      @else
        <div class="alert alert-warning">
          <strong>You can't change your faction right now.</strong>
          You last changed it on {!! format_date(Auth::user()->faction_changed, false) !!}.
          Faction can be changed {{ $location_interval }}.
        </div>
      @endif
    </div>
  @endif
  {{-- YOUR BIRTHDAY --}}
  <div class="card-full p-3 mb-2">
    <h3>Birthday Publicity</h3>
    {!! Form::open(['url' => 'account/dob']) !!}
    <div class="form-group row">
      <label class="col-md-2 col-form-label">Setting</label>
      <div class="col-md-10">
        {!! Form::select(
            'birthday_setting',

            [
                '0' => '0: No one can see your birthday.',
                '1' => '1: Members can see your day and month.',
                '2' => '2: Anyone can see your day and month.',
                '3' => '3: Full date public.'
            ],

            Auth::user()->settings->birthday_setting,

            ['class' => 'form-control']
        ) !!}
      </div>
    </div>
    <div class="text-right">
      {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  {{-- EMAIL ADDRESS --}}
  <div class="card-full p-3 mb-2">
    <h3>Allow Profile Comments</h3>
    {!! Form::open(['url' => 'account/comments']) !!}
    <p>If turned off, all comments on your profile will be hidden.</p>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">Setting</label>
      <div class="col-md-10">
        {!! Form::select(
            'allow_profile_comments',
            ['0' => '0: No one can comment on your profile.', '1' => '1: Users can comment on your profile.'],
            Auth::user()->settings->allow_profile_comments,
            ['class' => 'form-control']
        ) !!}
      </div>
    </div>
    <div class="text-right">
      {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>

  <div class="card-full p-3 mb-2">
    <h3>Character Warning Visibility</h3>
    <p>This setting will change how characters with content warnings are displayed to you.</p>
    {!! Form::open(['url' => 'account/warning']) !!}
    <div class="form-group row">
      <label class="col-md-2 col-form-label">Setting</label>
      <div class="col-md-10">
        {!! Form::select(
            'content_warning_visibility',
            [
                '0' => '0: Character has pop-up warning and censored icons.',
                '1' => '1: Character has pop-up warnings only.',
                '2' => '2: No warnings will appear on characters.'
            ],
            Auth::user()->settings->content_warning_visibility,
            ['class' => 'form-control']
        ) !!}
      </div>
    </div>
    <div class="text-right">
      {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>

  <div class="card-full p-3 mb-2">
    <h3>Email Address</h3>
    <p>Changing your email address will require you to re-verify your email address.</p>
    {!! Form::open(['url' => 'account/email']) !!}
    <div class="form-group row">
      <label class="col-md-2 col-form-label">Email Address</label>
      <div class="col-md-10">
        {!! Form::text('email', Auth::user()->email, ['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="text-right">
      {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  {{-- PASSWORD UPDATE --}}
  <div class="card-full p-3 mb-2">
    <h3>Change Password</h3>
    {!! Form::open(['url' => 'account/password']) !!}
    <div class="form-group row">
      <label class="col-md-2 col-form-label">Old Password</label>
      <div class="col-md-10">
        {!! Form::password('old_password', ['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">New Password</label>
      <div class="col-md-10">
        {!! Form::password('new_password', ['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label">Confirm New Password</label>
      <div class="col-md-10">
        {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="text-right">
      {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>

  <div class="card-full p-3 mb-2">
    <h3>Image Block Settings</h3>
    <p>This will disable or enable the image block widgets from showing.</p>
    <p>Note that this won't delete or unblock your existing image blocks, they will remain blurred for you.</p>
    {!! Form::open(['url' => 'account/blocked-image-setting']) !!}
    <div class="row">
      <div class="col form-group">
        {!! Form::checkbox('show_image_blocks', 1, Auth::user()->settings->show_image_blocks ? 1 : 0, [
            'class' => 'form-check-input',
            'data-toggle' => 'toggle'
        ]) !!}
        {!! Form::label('show_image_blocks', 'Show widgets?', ['class' => 'form-check-label ml-3']) !!}
      </div>
    </div>
    <div class="text-right">
      {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  {{-- TWO FACTOR AUTH --}}
  <div class="card-full p-3 mb-2">
    <h3>Two-Factor Authentication</h3>
    <hr>
    <h6>Coming soon!</h6>
    <span>
      Hi. This is <strong>pim</strong>, the Somnivores site developer. While 2FA comes with lorekeeper, lots of bugs have appeared
      over the course of the site's development. As such, I haven't yet had the opportunity to re-confirm that the 2FA setup process
      is completely functional end to end yet. Since something going wrong in that proccess can result in account lockouts, we've
      disabled it until we have the devtime to make sure everything is working fully, at which point we'll re-enable it!
    </span>
    {{-- <p>Two-factor authentication acts as a second layer of protection for your account. It uses an app on your phone-- such as
      Google Authenticator-- and information provided by the site to generate a random code that changes frequently.</p>

    <div class="alert alert-info">
      Please note that two-factor authentication is only used when logging in directly to the site (with an email address and
      password), and not when logging in via an off-site account. If you log in using an off-site account, consider enabling
      two-factor authentication on that site instead!
    </div>

    @if (!isset(Auth::user()->two_factor_secret))
      <p>In order to enable two-factor authentication, you will need to scan a QR code with an authenticator app on your phone.
        Two-factor authentication will not be enabled until you do so and confirm by entering one of the codes provided by your
        authentication app.</p>
      <hr>
      {!! Form::open(['url' => 'account/two-factor/enable']) !!}
      <div class="text-right">
        {!! Form::submit('Enable', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    @elseif(isset(Auth::user()->two_factor_secret))
      <p>Two-factor authentication is currently enabled.</p>

      <h4>Disable Two-Factor Authentication</h4>
      <p>To disable two-factor authentication, you must enter a code from your authenticator app.</p>
      {!! Form::open(['url' => 'account/two-factor/disable']) !!}
      <div class="form-group row">
        <label class="col-md-2 col-form-label">Code</label>
        <div class="col-md-10">
          {!! Form::text('code', null, ['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="text-right">
        {!! Form::submit('Disable', ['class' => 'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    @endif --}}
  </div>

  <script>
    $(document).ready(() => $('.selectize').selectize());
  </script>

  <div class="card-full p-3 mb-2">

    <h3>Character {{ ucfirst(__('character_likes.likes')) }} Setting</h3>
    {!! Form::open(['url' => 'account/character-likes']) !!}
    <div class="form-group row">
      <label class="col-md-2 col-form-label">Setting</label>
      <div class="col-md-10">
        {!! Form::select(
            'allow_character_likes',
            [
                '0' => 'Do not allow other users to ' . __('character_likes.like') . ' your characters.',
                '1' => 'Other users can ' . __('character_likes.like') . ' your characters.'
            ],
            Auth::user()->settings->allow_character_likes,
            ['class' => 'form-control']
        ) !!}
      </div>
    </div>
    <div class="text-right">
      {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  </div>

@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      refreshBorder();
    });

    $("#border").change(function() {
      refreshBorder();
    });

    function refreshBorder() {
      var border = $('#border').val();
      $.ajax({
        type: "GET",
        url: "{{ url('account/check-border') }}?border=" + border,
        dataType: "text"
      }).done(function(res) {
        $("#bordervariant").html(res);
      }).fail(function(jqXHR, textStatus, errorThrown) {
        alert("AJAX call failed: " + textStatus + ", " + errorThrown);
      });
      $.ajax({
        type: "GET",
        url: "{{ url('account/check-layers') }}?border=" + border,
        dataType: "text"
      }).done(function(res) {
        $("#layers").html(res);
      }).fail(function(jqXHR, textStatus, errorThrown) {
        alert("AJAX call failed: " + textStatus + ", " + errorThrown);
      });
    };
  </script>
@endsection
@section('scripts')
  <script>
    var $avatarCrop = $('#avatarCrop');
    var $cropper = $('#cropper');
    var c = null;
    var $x0 = $('#cropX0');
    var $y0 = $('#cropY0');
    var $x1 = $('#cropX1');
    var $y1 = $('#cropY1');
    var zoom = 0;

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $cropper.attr('src', e.target.result);
          c = new Croppie($cropper[0], {
            viewport: {
              width: 200,
              height: 200,
            },
            boundary: {
              width: 250,
              height: 250
            },
            update: function() {
              updateCropValues();
            }
          });
          updateCropValues();
          $avatarCrop.removeClass('hide');
          $cropper.removeClass('hide');
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#avatar").change(function() {
      readURL(this);
    });

    function updateCropValues() {
      var values = c.get();
      $x0.val(values.points[0]);
      $y0.val(values.points[1]);
      $x1.val(values.points[2]);
      $y1.val(values.points[3]);
    }
  </script>
@endsection
