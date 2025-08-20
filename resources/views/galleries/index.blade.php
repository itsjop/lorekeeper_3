@extends('galleries.layout', ['componentName' => 'galleries/index'])

@section('gallery-title')
  Home
@endsection

@section('gallery-content')
  {!! breadcrumbs(['Gallery' => 'gallery']) !!}
  <h1>
    @if (config('lorekeeper.extensions.show_all_recent_submissions.enable') &&
            config('lorekeeper.extensions.show_all_recent_submissions.links.indexbutton')
    )
      <div class="float-right">
        <a class="btn btn-primary" href="gallery/all">
          All Recent Submissions
        </a>
      </div>
    @endif
    Gallery
  </h1>
  <hr>
  @if ($galleries->count())
    {!! $galleries->render() !!}

    @foreach ($galleries as $gallery)
      <div class="card w-100">
        <div class="card-header">
          <h4>
            {!! $gallery->displayName !!}
            @if (Auth::check() && $gallery->canSubmit($submissionsOpen, Auth::user()))
              <a href="{{ url('gallery/submit/' . $gallery->id) }}" class="btn btn-primary float-right"><i class="fas fa-plus"></i></a>
            @endif
          </h4>
          @if ($gallery->children_count || (isset($gallery->start_at) || isset($gallery->end_at)))
            <p>
              @if (isset($gallery->start_at) || isset($gallery->end_at))
                @if ($gallery->start_at)
                  <strong>Open{{ $gallery->start_at->isFuture() ? 's' : 'ed' }}: </strong>{!! pretty_date($gallery->start_at) !!}
                @endif
                {{ $gallery->start_at && $gallery->end_at ? ' ・ ' : '' }}
                @if ($gallery->end_at)
                  <strong>Close{{ $gallery->end_at->isFuture() ? 's' : 'ed' }}: </strong>{!! pretty_date($gallery->end_at) !!}
                @endif
              @endif
              {{ $gallery->children_count && (isset($gallery->start_at) || isset($gallery->end_at)) ? ' ・ ' : '' }}
              @if ($gallery->children_count)
                Sub-galleries:
                @foreach ($gallery->children()->visible()->get() as $child)
                  {!! $child->displayName !!}{{ !$loop->last ? ', ' : '' }}
                @endforeach
              @endif
            </p>
          @endif
        </div>
        <div class="card-body">
          @if ($gallery->submissions_count)
            <div class="gallery grid-4-col card text-center">
              @foreach ($gallery->submissions->take(4) as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => true])
              @endforeach
            </div>
            @if ($gallery->submissions_count > 4)
              <div class="text-right">
                <a href="{{ url('gallery/' . $gallery->id) }}">See More...</a>
              </div>
            @endif
          @elseif(
              $gallery->children_count &&
                  $gallery->through('children')->has('submissions')->where('is_visible', 1)->where('status', 'Accepted')->count()
          )
            {{-- @elseif($gallery->children->count() && App\Models\Gallery\GallerySubmission::whereIn('gallery_id', $gallery->children->pluck('id')->toArray())->where('is_visible', 1)->where('status', 'Accepted')->count()) --}}
            <div class="gallery grid-4-col card text-center">
              @foreach ($gallery->through('children')->has('submissions')->where('is_visible', 1)->where('status', 'Accepted')->orderBy('created_at', 'DESC')->get()->take(4) as $submission)
                @include('galleries._thumb', ['submission' => $submission, 'gallery' => false])
              @endforeach
            </div>
          @else
            <p>This gallery has no submissions!</p>
          @endif
        </div>
      </div>
    @endforeach

    {!! $galleries->render() !!}
  @else
    <p>There aren't any galleries!</p>
  @endif

@endsection
