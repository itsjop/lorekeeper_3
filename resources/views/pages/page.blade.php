@extends('layouts.app', ['pageName' => '/pages'])

@section('title')
  {{ $page->title }}
@endsection

@section('content')
  <div id="custom-page">
    <x-admin-edit title="Page" :object="$page" />
    {{-- {!! breadcrumbs([$page->title => $page->url]) !!}
  <h1>
    @if (!$page->is_visible)
    <i class="fas fa-eye-slash mr-1"></i>
    @endif
    {{ $page->title }}
  </h1>
  <div class="mb-4">
    <div> Created {!! format_date($page->created_at) !!}</div>
    <div> Last updated {!! format_date($page->updated_at) !!}</div>
  </div> --}}

    <div id="custom-page-parsed" class="site-page-content parsed-text">
      {!! $page->parsed_text !!}
    </div>

    @if ($page->can_comment)
      <div class="container">
        @comments([
            'model' => $page,
            'perPage' => 5,
            'allow_dislikes' => $page->allow_dislikes
        ])
      </div>
    @endif
  </div>
@endsection


@section('sidebar')
  @include('pages._sidebar_page')
@endsection
