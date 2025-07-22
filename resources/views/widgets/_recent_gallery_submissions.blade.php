@if (config('lorekeeper.extensions.show_all_recent_submissions.enable') &&
        config('lorekeeper.extensions.show_all_recent_submissions.section_on_front')
)
  <div class="gallery gallery-recents grid-4-col card text-center">
    @if (count($gallerySubmissions))
      @foreach ($gallerySubmissions as $gallerySubmission)
        @include('galleries._thumb', ['submission' => $gallerySubmission, 'gallery' => false])
      @endforeach
    @else
      <div class="col-12">No Gallery Submissions.</div>
    @endif
  </div>
@endif
