@php
  if (isset($approved) and $approved == true) {
      if (isset($type) && $type != null) {
          $comments = $model->approvedComments->where('type', $type);
      } else {
          $comments = $model->approvedComments->where('type', 'User-User');
      }
  } else {
      if (isset($type) && $type != null) {
          $comments = $model->commentz->where('type', $type);
      } else {
          $comments = $model->commentz->where('type', 'User-User');
      }
  }

  // if (!isset($commentType)) {
  //     $commentType = 'comment';
  // }

@endphp

@if (!isset($type) || $type == 'User-User')
  <h2>Comments</h2>
@endif

<div class="d-flex mw-100 row mx-0" style="overflow:hidden;">
  @php
    $comments = $comments->sortByDesc('created_at');

    if (isset($perPage)) {
        $page = request()->query('page', 1) - 1;
        $parentComments = $comments->where('child_id', '');
        $slicedParentComments = $parentComments->slice($page * $perPage, $perPage);
        $m = config('comments.model'); // This has to be done like this, otherwise it will complain.
        $modelKeyName = (new $m())->getKeyName(); // This defaults to 'id' if not changed.
        $slicedParentCommentsIds = $slicedParentComments->pluck($modelKeyName)->toArray();
        // Remove parent Comments from comments.
        $comments = $comments->where('child_id', '!=', '');
        $grouped_comments = new \Illuminate\Pagination\LengthAwarePaginator(
            $slicedParentComments->merge($comments)->groupBy('child_id'),
            $parentComments->count(),
            $perPage
        );
        $grouped_comments->withPath(request()->url());
    } else {
        $grouped_comments = $comments->groupBy('child_id');
    }
  @endphp
  @foreach ($grouped_comments as $comment_id => $comments)
    {{-- Process parent nodes --}}
    @if ($comment_id == '')
      @foreach ($comments as $comment)
        @include('comments::_comment', [
            'comment' => $comment,
            'grouped_comments' => $grouped_comments,
            'limit' => 0,
            'compact' => $comment->type == 'Staff-Staff' ? true : false,
            'allow_dislikes' => isset($allow_dislikes) ? $allow_dislikes : false
        ])
      @endforeach
    @endif
  @endforeach
</div>

@if ($comments->count() < 1)
  <div class="alert alert-warning">There are no comments yet.</div>
@endif

@isset($perPage)
  <div class="ml-auto mt-2">{{ $grouped_comments->links() }}</div>
@endisset

@auth
  @include('comments._form', [
      'compact' => isset($type) && $type == 'Staff-Staff' && config('lorekeeper.settings.wysiwyg_comments') ? true : false
  ])
@else
  <div class="card mt-3">
    <div class="card-body">
      <h5 class="card-title">Authentication required</h5>
      <p class="card-text">You must log in to post a comment.</p>
      <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
    </div>
  </div>
@endauth

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      tinymce.init({
        selector: '.comment-wysiwyg',
        height: 250,
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
          '{{ asset('css/lorekeeper.css') }}'
        ],
        spoiler_caption: 'Toggle Spoiler',
        target_list: false,
        indent_before: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
          'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
        indent_after: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
          'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
        whitespace_elements: 'p pre script noscript style textarea video audio iframe object code',

      });

      // function sortComments() {
      //   $('#comments').fadeOut();
      //   $.ajax({
      //     url: "{{ url('sort-comments/' . base64_encode(urlencode(get_class($model))) . '/' . $model->getKey()) }}",
      //     type: 'GET',
      //     data: {
      //       url: '{{ url()->current() }}',
      //       allow_dislikes: '{{ isset($allow_dislikes) ? $allow_dislikes : false }}',
      //       approved: '{{ isset($approved) ? $approved : false }}',
      //       type: '{{ isset($type) ? $type : null }}',
      //       sort: $('#sort').val(),
      //       perPage: $('#perPage').val(),
      //       page: '{{ request()->query('page') }}',
      //     },
      //     success: function(data) {
      //       $('#comments').html(data);
      //       // update current url to reflect sort change
      //       var url = new URL(window.location.href);
      //       url.searchParams.set('sort', $('#sort').val());
      //       url.searchParams.set('perPage', $('#perPage').val());

      //       window.history.pushState({}, '', url);
      //       $('#comments').fadeIn();
      //     }
      //   });
      // }

      // $('#sort').change(function() {
      //   sortComments();
      // });

      // $('#perPage').change(function() {
      //   sortComments();
      // });

      // sortComments(); // initial sort
    });
  </script>
@endsection
