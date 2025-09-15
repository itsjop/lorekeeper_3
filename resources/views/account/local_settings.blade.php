@extends('account.layout', ['componentName' => 'account/settings'])

@section('account-title')
  Local Settings
@endsection

@section('account-content')
  {!! breadcrumbs(['My Account' => Auth::user()->url, 'Local Settings' => 'account/settings']) !!}

  <div class="local-settings">
    <h1> Local Settings (new!)</h1>
    <hr>
    <h1>Note from the developer:</h1>
    <h2>The following website settings are <u>saved to your browser only</u> and are <u>not</u> synced to your user account.</h2>
    <p>You should only need to set them once per device, but account synching will come later. Thanks!</p>
    <hr>
    {{-- <div class="setting-group">
      <div class="flex gap-1">

        <label class="m-0" for="site-theme">
          <h3>Site-wide Theme:</h3>
        </label>
        <select
          name="theme"
          id="site-theme"
          onchange='updateSiteTheme(this);'
        >
          <option value="light"> Light Theme </option>
          <option value="dark"> Dark Theme </option>
          <option value="system"> Match System Theme </option>
        </select>
      </div>
      <hr>
    </div> --}}
    <div class="setting-group">
      <h2>Site Graphical Features:</h2>
      <div class="setting backdrop-blur">
        <div class="flex gap-1 ac-center ai-center">
          <label class="m-0" for="scales">Main content backdrop blur effect</label>
          <input
            type="checkbox"
            id="backdrop"
            name="backdrop-blur"
            data-toggle="toggle"
            onchange='updateBackdropBlur(this);'
          />
        </div>
        <p class="small mx-4">This toggles the frosted blur effect on the main content.
          We've optmised it as much as we can but there may be instances where you may want it disabled for performance, or
          otherwise.</p>
      </div>
      <div class="setting site-animations">
        <div class="flex gap-1 ac-center ai-center">
          <label class="m-0" for="scales">Persistent Site Animations</label>
          <input
            type="checkbox"
            id="animations"
            name="backdrop-blur"
            data-toggle="toggle"
            onchange='updateAnimations(this);'
          />
        </div>
        <p class="small mx-4">
          This toggles persistent site animations that play regardless of user interaction. (e.g. moving backgrounds)
        </p>
      </div>
      <div class="setting image-hover">
        <div class="flex gap-1 ac-center ai-center">
          <label class="m-0" for="hover-effects">
            Hover Effects:
          </label>
          <select
            name="hover-effects"
            id="hover-effects"
            onchange='updateHoverEffect(this);'
          >
            <option value="default"> Default </option>
            <option value="reduced"> Reduced </option>
            <option value="instant"> Instant </option>
          </select>
        </div>
        <p class="small mx-4 my-0">
          This is the setting for any animation that plays upon a user action (usually hovering). There are 3 settings:
        <ul class="small mx-4">
          <li>Default - The normal somnivores interaction animations.</li>
          <li>Reduced - Interaction animations are still present, but simplified and smoothed to be less jarring.</li>
          <li>Instant - Interaction animations are instantaneous. </li>
        </ul>
        </p>
      </div>
      <h4 class="ta-center">All changes are saved instantly.</h4>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  <script>
    function updateSiteTheme(e) {
      console.log("som_siteTheme", e);
      localStorage.setItem("som_siteTheme", e.value);
      console.log("som_siteTheme", localStorage.getItem("som_siteTheme"));
      applyLocalSettings();
    }

    function updateBackdropBlur(e) {
      console.log("som_backdropBlur", e.checked);
      localStorage.setItem("som_backdropBlur", e.checked );
      console.log("som_backdropBlur", localStorage.getItem("som_backdropBlur"));
      applyLocalSettings();
    }

    function updateAnimations(e) {
      console.log("som_animations", e.checked);
      localStorage.setItem("som_animations", e.checked );
      console.log("som_animations", localStorage.getItem("som_animations"));
      applyLocalSettings();
    }

    function updateHoverEffect(e) {
      console.log("som_effects", e);
      localStorage.setItem("som_effects", e.value);
      console.log("som_effects", localStorage.getItem("som_effects"));
      applyLocalSettings();
    }
    $(document).ready(function() {
      document.getElementById("site-theme").value = localStorage.getItem("som_siteTheme");
      document.getElementById("backdrop").checked = localStorage.getItem("som_backdropBlur") === 'true';
      document.getElementById("animations").checked = localStorage.getItem("som_animations") === 'true';
      document.getElementById("hover-effects").value = localStorage.getItem("som_effects");
    })
  </script>
@endsection
