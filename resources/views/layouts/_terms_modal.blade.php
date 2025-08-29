@if (Config::get('lorekeeper.settings.show_terms_popup') == 1)
  <div
    class="modal fade d-none"
    id="termsModal"
    role="dialog"
    style="display:inline;overflow:auto;"
    data-backdrop="static"
    data-keyboard="false"
  >
    <div
      class="modal-dialog"
      role="document"
      style="padding: 10px 2vw"
    >
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title text-center w-100">{{ Config::get('lorekeeper.settings.terms_popup')['title'] }}</h1>
        </div>
        <hr class="m-0">
        <div class="modal-body">
          <h1 style="text-align:center">Somnivores is an 18+ Community!</h1>
          <ul style="margin-left: 2em;">
            <li>Any users under 18 will be banned.</li>
            <li>You must review of our <strong>ARPG Content Warnings & Terms</strong> of Service before engaging with the site!
            </li>
          </ul>
          <hr>
          <p>
            While Reverie is generally colorful and cheerful, our world and lore does (or will) contain the following
            topics:
          </p>
          <h2 style="text-align:center">Content Warnings</h2>
          <ul style="margin-left: 2em;">
            <li>Insects (Foods, Trait items & an insect tail trait which includes centipedes)</li>
            <li>Hunger & Starvation</li>
            <li>Loss of Self / Derealization / Mental Decline</li>
            <li>Humans as a Food Source (Dream Eating, Vampirism)</li>
            <li>Violence & Large-Scale Conflicts</li>
            <li>Bodily Experimentation</li>
            <li>Nightmare-Related Horror</li>
            <li>Fictional Religions / Cults</li>
          </ul>

          <p>
            Instances that could be triggering will have filters and/or content warnings to the best of our ability, but
            if you are particularly sensitive to any of these topics I encourage you to
            <strong>proceed with caution</strong>, or consider if our community might not be a good fit.
          </p>

          <hr>
          <h5 style="text-align:center">
            Please view the
            <a
              href="https://somnivores.com/info/terms"
              style="text-decoration: underline"
              class="h2"
            > Full Terms of Service </a>
            before proceeding.
          </h5>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-primary"
            id="termsButton"
          >
            Accept Terms
          </button>
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="fade modal-backdrop d-none" id="termsBackdrop"></div> --}}

  <script>
    $(document).ready(function() {
      var termsButton = $('#termsButton');
      let termsAccepted = localStorage.getItem("terms_accepted");
      let user = "{{ Auth::user() != null }}"
      let userAccepted = "{{ Auth::user()?->has_accepted_terms > 0 }}"

      if (user) {
        if (!userAccepted) {
          showPopup();
        }
      } else {
        if (!termsAccepted) {
          showPopup();
        }
      }

      termsButton.on('click', function(e) {
        e.preventDefault();
        localStorage.setItem("terms_accepted", true);
        window.location.replace("/terms/accept");
      });

      function showPopup() {
        $('#termsModal').addClass("show");
        $('#termsModal').removeClass("d-none");
        $('#termsBackdrop').addClass("show");
        $('#termsBackdrop').removeClass("d-none");
      }

    });
  </script>
@endif
