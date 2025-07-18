@extends('home.layout', ['componentName' => 'home/create-submission'])

@section('home-title')
  New Submission
@endsection

@section('home-content')
  @if ($isClaim)
    {!! breadcrumbs(['Claims' => 'claims', 'New Claim' => 'claims/new']) !!}
  @else
    {!! breadcrumbs(['Prompt Submissions' => 'submissions', 'New Submission' => 'submissions/new']) !!}
  @endif

  <h1>
    @if ($isClaim)
      New Claim
    @else
      New Submission
    @endif
  </h1>

  @if ($closed)
    <div class="alert alert-danger">
      The {{ $isClaim ? 'claim' : 'submission' }} queue is currently closed. You cannot make a new
      {{ $isClaim ? 'claim' : 'submission' }} at this time.
    </div>
  @else
    @include('home._submission_form', [
        'submission' => $submission,
        'criteria' => $isClaim ? null : $criteria,
        'isClaim' => $isClaim,
        'userGallerySubmissions' => $userGallerySubmissions,
    ])
    <dialog class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">

        <div class="modal-content hide" id="confirmContent">
          <div class="modal-header">
            <span class="modal-title h5 mb-0">Confirm {{ $isClaim ? 'Claim' : 'Submission' }}</span>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p>
              This will submit the form and put it into the {{ $isClaim ? 'claims' : 'prompt' }} approval queue.
              You will not be able to edit the contents after the {{ $isClaim ? 'claim' : 'submission' }} has been made.
              If you aren't certain that you are ready, consider saving as a draft instead.
              Click the Confirm button to complete the {{ $isClaim ? 'claim' : 'submission' }}.
            </p>
            @if (!$isClaim)
              <div id="requirementsWarning">
              </div>
            @endif
            <div class="text-right">
              <a href="#" id="confirmSubmit" class="btn btn-primary">Confirm</a>
            </div>
          </div>
        </div>

        <div class="modal-content hide" id="draftContent">
          <div class="modal-header">
            <span class="modal-title h5 mb-0">Create Draft</span>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p>
              This will place the {{ $submission->prompt_id ? 'submission' : 'claim' }} into your drafts.
              Items and other attachments will be held, similar to in design update drafts.
            </p>
            <div class="text-right">
              <a href="#" id="draftSubmit" class="btn btn-success">
                Save as Draft
              </a>
            </div>
          </div>
        </div>
      </div>
      </div>
  @endif
@endsection

@section('scripts')
  @parent
  @if (!$closed)
    @if ($isClaim)
      @include('js._loot_js', [
          'showLootTables' => false,
          'showRaffles' => true,
          'showRecipes' => true,
      ])
    @else
      @include('js._loot_js', [
          'showLootTables' => false,
          'showRaffles' => false,
          'showRecipes' => false,
      ])
    @endif
    @include('js._character_select_js')
    @include('widgets._inventory_select_js', ['readOnly' => true])
    @include('widgets._bank_select_row', ['owners' => [Auth::user()]])
    @include('widgets._bank_select_js', [])

    <script>
      $(document).ready(function() {
        var $confirmationModal = $('#confirmationModal');
        var $submissionForm = $('#submissionForm');

        var $confirmButton = $('#confirmButton');
        var $confirmContent = $('#confirmContent');
        var $confirmSubmit = $('#confirmSubmit');

        var $draftButton = $('#draftButton');
        var $draftContent = $('#draftContent');
        var $draftSubmit = $('#draftSubmit');

        @if (!$isClaim)
          var $prompt = $('#prompt');
          var $rewards = $('#rewards');
          var $requirementsWarning = $('#requirementsWarning');

          $prompt.selectize();
          $prompt.on('change', function(e) {
            $rewards.load('{{ url('submissions/new/prompt') }}/' + $(this).val());
            $requirementsWarning.load('{{ url('submissions/new/prompt') }}/' + $(this).val() + '/requirements');
            $('#copy-calc').load('{{ url('criteria/prompt') }}/' + $(this).val());
            if ($(this).val()) $('#criterion-section').removeClass('hide');
          });

          if ($prompt.val()) {
            $rewards.load('{{ url('submissions/new/prompt') }}/' + $prompt.val());
            $requirementsWarning.load('{{ url('submissions/new/prompt') }}/' + $prompt.val() + '/requirements');
          }
        @endif

        $confirmButton.on('click', function(e) {
          e.preventDefault();
          $confirmContent.removeClass('hide');
          $draftContent.addClass('hide');
          $confirmationModal.modal('show');
        });

        $confirmSubmit.on('click', function(e) {
          e.preventDefault();
          let $confirm = $('#requirementsWarning').find('#confirm').length ? $('#requirementsWarning').find('#confirm').is(
            ':checked') : true;
          if ("{{ !$isClaim }}" && !$confirm) {
            alert(
              'You must confirm that you understand that you will not be able to edit this submission after it has been made.'
            );
            return;
          }
          $submissionForm.attr('action', '{{ url()->current() }}');
          $submissionForm.submit();
        });

        $draftButton.on('click', function(e) {
          e.preventDefault();
          $draftContent.removeClass('hide');
          $confirmContent.addClass('hide');
          $confirmationModal.modal('show');
        });

        $draftSubmit.on('click', function(e) {
          e.preventDefault();
          $submissionForm.attr('action', '{{ url()->current() }}/draft');
          $submissionForm.submit();
        });

        $('.add-calc').on('click', function(e) {
          e.preventDefault();
          var clone = $('#copy-calc').clone();
          clone.removeClass('hide');
          var input = clone.find('[name*=criterion]');
          var count = $('.criterion-select').length;
          input.attr('name', input.attr('name').replace('#', count))
          clone.find('.criterion-select').on('change', loadForm);
          clone.find('.delete-calc').on('click', deleteCriterion);
          clone.removeAttr('id');
          $('#criteria').append(clone);
        });

        $('.delete-calc').on('click', deleteCriterion);

        function deleteCriterion(e) {
          e.preventDefault();
          var toDelete = $(this).closest('.card');
          toDelete.remove();
        }

        function loadForm(e) {
          var id = $(this).val();
          var promptId = $prompt.val();
          var formId = $(this).attr('name').split('[')[1].replace(']', '');

          if (id) {
            var form = $(this).closest('.card').find('.form');
            form.load("{{ url('criteria/prompt') }}/" + id + "/" + promptId + "/" + formId, (response, status, xhr) => {
              if (status == "error") {
                var msg = "Error: ";
                console.error(msg + xhr.status + " " + xhr.statusText);
              } else {
                form.find('[data-bs-toggle=tooltip]').tooltip({
                  html: true
                });
                form.find('[data-bs-toggle=toggle]').bootstrapToggle();
              }
            });
          }
        }

        $('.criterion-select').on('change', loadForm);
      });
    </script>
  @endif
@endsection
