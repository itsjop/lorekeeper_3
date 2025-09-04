{{-- Action buttons --}}
@if (Auth::check())
  <div class="flex flex-wrap jc-end">
    {{-- <div class="grid grid-4-col"> --}}
    @can('reply-to-comment', $comment)
      <button
        data-bs-toggle="modal"
        data-bs-target="#reply-modal-{{ $comment->getKey() }}"
        class="btn btn-sm p-2 btn-outline small flex gap-_5 jc-center ai-center"
      >
        <i class="fas fa-comment"></i>
        <span class="d-none d-lg-block">Reply</span>
      </button>
    @endcan
    @can('edit-comment', $comment)
      <button
        data-bs-toggle="modal"
        data-bs-target="#comment-modal-{{ $comment->getKey() }}"
        class="btn btn-sm p-2 btn-outline small flex gap-_5 jc-center ai-center"
      >
        <i class="fas fa-edit"></i>
        <span class="d-none d-lg-block">Edit</span>
      </button>
    @endcan
    @if (
        ((Auth::user()->id == $comment->commentable_id && $comment->commentable_type == 'App\Models\User\UserProfile') ||
            Auth::user()->isStaff) &&
            (isset($compact) && !$compact)
    )
      <button
        data-bs-toggle="modal"
        data-bs-target="#feature-modal-{{ $comment->getKey() }}"
        class="btn btn-sm p-2 btn-outline small flex gap-_5 jc-center ai-center"
      >
        <i class="fas fa-star"></i>
        <span class="d-none d-lg-block">{{ $comment->is_featured ? 'Unf' : 'F' }}eature</span>
      </button>
    @endif
    @can('delete-comment', $comment)
      <button
        data-bs-toggle="modal"
        data-bs-target="#delete-modal-{{ $comment->getKey() }}"
        class="btn btn-sm p-2 btn-outline-danger small flex gap-_5 jc-center ai-center"
      >
        <i class="fas fa-minus-circle"></i>
        <span class="d-none d-lg-block">Delete</span>
      </button>
    @endcan

    <div class="flex jc-center gap-_5 ai-center btn btn-outline">
      {{-- Likes Section --}}
      <a
        href="#"
        data-bs-toggle="modal"
        data-bs-target="#show-likes-{{ $comment->id }}"
      >
        <button
          href="#"
          data-bs-toggle="tooltip"
          title="Click to View"
          class="btn btn-sm p-0 m-0 color-white btn-faded small"
        >
          <span>{{ $comment->likes()->where('is_like', 1)->count() - $comment->likes()->where('is_like', 0)->count() }}</span>
          <span class="d-none d-lg-inline pl-1">{{ $comment->likes()->where('is_like', 1)->count() - $comment->likes()->where('is_like', 0)->count() != 1 ? 'Likes' : 'Like' }}</span>
        </button>
      </a>
      {!! Form::open(['url' => 'comments/' . $comment->id . '/like/1', 'class' => 'd-inline-block']) !!}
      {!! Form::button('<i class="fas fa-thumbs-up"></i>', [
          'type' => 'submit',
          'class' =>
              'btn btn-sm m-0 p-0 ' .
              ($comment->likes()->where('user_id', Auth::user()->id)->where('is_like', 1)->exists()
                  ? 'btn-success'
                  : 'btn-outline-success') .
              ' small ai-center'
      ]) !!}
      {!! Form::close() !!}
      @if (Settings::get('comment_dislikes_enabled') || (isset($allow_dislikes) && $allow_dislikes))
        {!! Form::open(['url' => 'comments/' . $comment->id . '/like/0', 'class' => 'd-inline-block']) !!}
        {!! Form::button('<i class="fas fa-thumbs-down"></i>', [
            'type' => 'submit',
            'class' =>
                'btn btn-sm p-0 px-3 py-2 px-sm-2 py-sm-1 ' .
                ($comment->likes()->where('user_id', Auth::user()->id)->where('is_like', 0)->exists()
                    ? 'btn-danger'
                    : 'btn-outline-danger') .
                ' small ai-center'
        ]) !!}
        {!! Form::close() !!}
      @endif
    </div>
  </div>
@endif

{{-- Modals --}}
@can('edit-comment', $comment)
  <dialog
    class="modal fade"
    id="comment-modal-{{ $comment->getKey() }}"
    tabindex="-1"
    role="dialog"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        {{ Form::model($comment, ['route' => ['comments.update', $comment->getKey()]]) }}
        <div class="modal-header">
          <h5 class="modal-title">Edit Comment</h5>
          <button
            type="button"
            class="close"
            data-bs-dismiss="modal"
          >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            {!! Form::label('message', 'Update your message here:') !!}
            {!! Form::textarea('message', $comment->comment, [
                'class' => 'form-control ' . (config('lorekeeper.settings.wysiwyg_comments') ? 'comment-wysiwyg' : ''),
                'rows' => 3,
                config('lorekeeper.settings.wysiwyg_comments') ? '' : 'required'
            ]) !!}
            <small class="form-text text-muted">
              <a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a>
              cheatsheet.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-sm p-0 m-0 btn-outline-secondary small ai-center"
            data-bs-dismiss="modal"
          >Cancel</button>
          {!! Form::submit('Update', ['class' => 'btn btn-sm p-0 m-0 btn-outline-success small ai-center']) !!}
        </div>
        </form>
      </div>
    </div>
  </dialog>
@endcan
{{-- modal large --}}
@can('reply-to-comment', $comment)
  <dialog
    class="modal fade"
    id="reply-modal-{{ $comment->getKey() }}"
    tabindex="-1"
    role="dialog"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        {{ Form::open(['route' => ['comments.reply', $comment->getKey()]]) }}
        <div class="modal-header">
          <h5 class="modal-title">Reply to Comment</h5>
          <button
            type="button"
            class="close"
            data-bs-dismiss="modal"
          >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            {!! Form::label('message', 'Enter your message here:') !!}
            {!! Form::textarea('message', null, [
                'class' => 'form-control ' . (config('lorekeeper.settings.wysiwyg_comments') ? 'comment-wysiwyg' : ''),
                'rows' => 3,
                config('lorekeeper.settings.wysiwyg_comments') ? '' : 'required'
            ]) !!}
            <small class="form-text text-muted">
              <a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a>
              cheatsheet.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-sm btn-danger"
            data-bs-dismiss="modal"
          >
            Cancel
          </button>
          {!! Form::submit('Reply', ['class' => 'btn btn-sm btn-outline-success ']) !!}
        </div>
        </form>
      </div>
    </div>
  </dialog>
@endcan

@can('delete-comment', $comment)
  <dialog
    class="modal fade"
    id="delete-modal-{{ $comment->getKey() }}"
    tabindex="-1"
    role="dialog"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Comment</h5>
          <button
            type="button"
            class="close"
            data-bs-dismiss="modal"
          >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">Are you sure you want to delete this comment?</div>
          <div class="alert alert-warning">
            <strong>Comments can be restored in the database.</strong>
            <br> Deleting a comment does not delete the comment record.
          </div>
          <div class="text-right">
            <a
              href="{{ route('comments.destroy', $comment->getKey()) }}"
              onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->getKey() }}').submit();"
              class="btn btn-danger small ai-center"
            >Delete</a>
            <form
              id="comment-delete-form-{{ $comment->getKey() }}"
              action="{{ route('comments.destroy', $comment->getKey()) }}"
              method="POST"
              style="display: none;"
            >
              @method('DELETE')
              @csrf
            </form>
          </div>
        </div>
      </div>
    </div>
  </dialog>
@endcan

<dialog
  class="modal fade"
  id="feature-modal-{{ $comment->getKey() }}"
  tabindex="-1"
  role="dialog"
>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $comment->is_featured ? 'Unf' : 'F' }}eature Comment</h5>
        <button
          type="button"
          class="close"
          data-bs-dismiss="modal"
        >
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">Are you sure you want to {{ $comment->is_featured ? 'un' : '' }}feature this comment?</div>
      </div>
      <div class="alert alert-warning">Comments can be unfeatured.</div>
      {!! Form::open(['url' => 'comments/' . $comment->id . '/feature']) !!}
      @if (!$comment->is_featured)
        {!! Form::submit('Feature', ['class' => 'btn btn-primary w-100 mb-0 mx-0']) !!}
      @else
        {!! Form::submit('Unfeature', ['class' => 'btn btn-primary w-100 mb-0 mx-0']) !!}
      @endif
      {!! Form::close() !!}
    </div>
  </div>
</dialog>

<dialog
  class="modal fade"
  id="show-likes-{{ $comment->id }}"
  tabindex="-1"
  role="dialog"
>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Likes</h5>
        <button
          type="button"
          class="close"
          data-bs-dismiss="modal"
        >
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if (count($comment->likes) > 0)
          <div class="mb-4 logs-table">
            <div class="logs-table-header">
              <div class="row">
                <div class="col-4 col-md-3">
                  <div class="logs-table-cell">User</div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="logs-table-cell"></div>
                </div>
                <div class="col-4 col-md-3">
                  <div class="logs-table-cell"></div>
                </div>
              </div>
            </div>
            <div class="logs-table-body">
              @foreach ($comment->likes as $like)
                <div class="logs-table-row">
                  <div class="row flex-wrap">
                    <div class="col-4 col-md-3">
                      <div class="logs-table-cell">
                        <img style="max-height: 2em;" src="{{ $like->user->avatarUrl }}" />
                      </div>
                    </div>
                    <div class="col-12 col-md-4">
                      <div class="logs-table-cell">{!! $like->user->displayName !!}</div>
                    </div>
                    <div class="col-4 col-md-4 text-right">
                      <div class="logs-table-cell">{!! $like->is_like ? '<i class="fas fa-thumbs-up"></i>' : '<i class="fas fa-thumbs-down"></i>' !!}</div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @else
          <div class="alert alert-info">No likes yet.</div>
        @endif
      </div>
    </div>
  </div>
</dialog>

{{-- edits modal --}}
{{-- the button for this appears in the main view, but to keep it from being cluttered we will keep the models within this section --}}
@if (Auth::check() && Auth::user()->isStaff)
  <dialog
    class="modal fade"
    id="show-edits-{{ $comment->id }}"
    tabindex="-1"
    role="dialog"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit History</h5>
          <button
            type="button"
            class="close"
            data-bs-dismiss="modal"
          >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if (count($comment->edits) > 0)
            <div class="mb-4 logs-table">
              <div class="logs-table-header">
                <div class="row">
                  <div class="col-4 col-md-3">
                    <div class="logs-table-cell">Time</div>
                  </div>
                  <div class="col-12 col-md-4">
                    <div class="logs-table-cell">Old Comment</div>
                  </div>
                  <div class="col-4 col-md-3">
                    <div class="logs-table-cell">New Comment</div>
                  </div>
                </div>
              </div>
              <div class="logs-table-body">
                @foreach ($comment->edits as $edit)
                  <div class="logs-table-row">
                    <div class="row flex-wrap">
                      <div class="col-4 col-md-3">
                        <div class="logs-table-cell">
                          {!! format_date($edit->created_at) !!}
                        </div>
                      </div>
                      <div class="col-12 col-md-4">
                        <div class="logs-table-cell">
                          <span data-bs-toggle="tooltip" title="{{ $edit->data['old_comment'] }}">
                            {{ Str::limit($edit->data['old_comment'], 50) }}
                          </span>
                        </div>
                      </div>
                      <div class="col-12 col-md-4">
                        <div class="logs-table-cell">
                          <span data-bs-toggle="tooltip" title="{{ $edit->data['new_comment'] }}">
                            {{ Str::limit($edit->data['new_comment'], 50) }}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @else
            <div class="alert alert-info">No edits yet.</div>
          @endif
        </div>
      </div>
    </div>
  </dialog>
@endif
