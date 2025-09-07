@extends('world.layout')

@section('world-title')
  {{ $title->title }}
@endsection

@section('meta-img')
  {{ $title->imageUrl }}
@endsection

@section('content')
  <x-admin-edit title="Title" :object="$title" />
  {!! breadcrumbs(['World' => 'world', 'Titles' => 'world/titles', $title->title => $title->idUrl]) !!}

  <div class="row">
    <div class="col-sm">
    </div>
    <div class="col-lg-6 col-lg-10">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row world-entry">
            @if ($title->imageUrl)
              <div class="col-md-3 world-entry-image">
                <a
                  href="{{ $title->imageUrl }}"
                  data-lightbox="entry"
                  data-title="{{ $title->title }}"
                >
                  <img
                    src="{{ $title->imageUrl }}"
                    class="world-entry-image"
                    alt="{{ $title->title }}"
                  />
                </a>
              </div>
            @endif
            <div class="{{ $title->imageUrl ? 'col-md-9' : 'col-12' }}">
              <h1>
                {!! $title->displayNameFull !!}
                <div class="float-right small">
                  @if (isset($title->searchCharactersUrl) && $title->searchCharactersUrl)
                    <a href="{{ $title->searchCharactersUrl }}" class="world-entry-search text-muted small ml-4">
                      <i class="fas fa-search"></i> Characters</a>
                  @endif
                </div>
              </h1>
              @if ($title->short_title)
                <h5>
                  <em>{!! $title->short_title !!}</em>
                </h5>
              @endif
              <div class="world-entry-text">
                {!! $title->description !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm">
    </div>
  </div>
@endsection
