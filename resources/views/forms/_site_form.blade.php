<div class="card mb-3">
    <div class="card-header">
        <h2 class="card-title mb-0">
            @if(!$form->is_active || ($form->is_active && $form->is_timed && $form->start_at > Carbon\Carbon::now())) 
                    <i class="fas fa-eye-slash mr-1" data-toggle="tooltip" title="This form is hidden."></i>
              @endif
            {!! $form->displayName !!}
        </h2>
        <div class="h5">
            <span class="badge bg-warning border">
                @if($form->is_anonymous)
                This form is anonymous {!! add_help('Staff will be unable to see your answers, however, the site owners may still access this information through the database.') !!}
                @else
                This form is not anonymous. {!! add_help('Staff will be able to easily see your answers.') !!}
                @endif
            </span>
        </div>
        <small>
            Posted {!! $form->post_at ? pretty_date($form->post_at) : pretty_date($form->created_at) !!} :: Last edited {!! pretty_date($form->updated_at) !!} by {!! $form->user->displayName !!}
        </small>
    </div>
    <div class="card-body">
        <div class="parsed-text">
            {!! $form->parsed_description ?? '<i>This form has no description.</i>' !!}
        </div>
        @if($page)
            @if((!$user || $form->answers->where('user_id', $user->id)->count() > 0) && !$edit)
                @include('forms._site_form_results')
            @else
                @include('forms._site_form_edit')
            @endif
        @endif
    </div>
    <?php $commentCount = App\Models\Comment::where('commentable_type', 'App\Models\Forms\SiteForm')->where('commentable_id', $form->id)->count(); ?>
    @if(!$page)
         <hr>
        <div class="text-right mb-2 mr-2">
            <a class="btn" href="{{ $form->url }}"><i class="fas fa-comment"></i> {{ $commentCount }} Comment{{ $commentCount != 1 ? 's' : ''}}</a>
        </div>
    @else
        <div class="text-right mb-2 mr-2">
            <span class="btn"><i class="fas fa-comment"></i> {{ $commentCount }} Comment{{ $commentCount != 1 ? 's' : ''}}</span>
        </div>
    @endif
</div>