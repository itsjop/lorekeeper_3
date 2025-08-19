@if (isset($submission->content_warning))
  <img
    loading="lazy"
    class="img-thumbnail"
    src="{{ asset('images/somnivores/site/content-warning.png') }}"
    alt="Content Warning"
  />
@elseif(isset($submission->hash))
  <img
    loading="lazy"
    class="img-thumbnail"
    src="{{ $submission->thumbnailUrl }}"
    alt="Submission thumbnail"
  />
@else
  <div class="mx-auto img-thumbnail text-left"
    style=""
  >
    <span class="badge-primary px-2 py-1" style="border-radius:0 0 .5em 0; position:absolute; z-index:5;">Literature</span>
    <img
      loading="lazy"
      class="img-thumbnail"
      src="{{ asset('images/somnivores/site/donation-shop.png') }}"
      alt="Submission thumbnail"
    />

  </div>
  <style>
    .content-{{ $submission->id }} {
      transition-duration: {{ strlen(substr($submission->parsed_text, 0, 500)) / 1000 }}s;
    }

    .content-{{ $submission->id }}:hover,
    .content-{{ $submission->id }}:focus-within {
      transform: translateY(calc({{ config('lorekeeper.settings.masterlist_thumbnails.height') }}px - 100%));
      transition-duration: {{ strlen(substr($submission->parsed_text, 0, 500)) / 100 }}s;
    }
  </style>
@endif
