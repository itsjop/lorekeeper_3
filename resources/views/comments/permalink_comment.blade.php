@extends('layouts.app', ['pageName' => '/_perma-layout'])

@section('title')
  Comments
@endsection

@section('profile-title')
  Comment
@endsection

@section('content')
  <h1>Comments on {!! $comment->commentable_type == 'App\Models\User\UserProfile'
      ? $comment->commentable->user->displayName
      : $comment->commentable->displayName !!}</h1>
  <h5>
    @if (count($comment->children))
      <a href="{{ url('comment/') . '/' . $comment->endOfThread->id }}" class="btn btn-secondary btn-sm mr-2">Go To End Of Thread</a>
    @endif
    @if (isset($comment->child_id))
      <a href="{{ url('comment/') . '/' . $comment->child_id }}" class="btn btn-secondary btn-sm mr-2">See Parent</a>
      <a href="{{ url('comment/') . '/' . $comment->topComment->id }}" class="btn btn-secondary btn-sm mr-2">Go To Top Comment</a>
    @endif
  </h5>

  <hr class="mb-3">
  <div class="d-flex mw-100 row mx-0" style="overflow:hidden;">
    @include('comments._perma_comments', ['comment' => $comment, 'limit' => 0, 'depth' => 0])
  </div>
@endsection
@section('scripts')
  <script>
    $(document).ready(function() {
      tinymce.init({
        selector: '.comment-wysiwyg',
        height: 300,
        menubar: false,
        convert_urls: false,
        plugins: [
          'advlist forecolor fontselect fontsizeselect  autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen spoiler',
          'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect fontselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
        content_css: [
          '{{ asset('css/app.css') }}',
          '{{ asset('css/vendor/lorekeeper.css') }}'
        ],
        spoiler_caption: 'Toggle Spoiler',
        target_list: false,
        indent_before: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
          'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
        indent_after: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
          'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
        whitespace_elements: 'p pre script noscript style textarea video audio iframe object code',

      });
    });
  </script>
@endsection
