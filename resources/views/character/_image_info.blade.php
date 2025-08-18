{{-- Image Data --}}
<div
  id="info-col"
  class="info-col info-tab card-body"
  id="info-{{ $image->id }}"
>
  <div class="quick-info">
    <h5 class="ruled-left text-600">{!! $image->species_id ? $image->species->displayName : 'None' !!}</h5>
    <div class="flex gap-_5 jc-center">
      <div class="rarity flex h6 no-break">{!! $image->rarity_id ? $image->rarity->displayName : 'None' !!} </div>
      <img src="{{ asset('images/subtypes/badges/' . getSubtypeInfo($character->image->subtype_id) . '.png') }}"
        style="height: 1.5em; margin-right: 0.1em;"
      >
      <div class="palate h6 flex">
        <a href="{{ isset($image->subtype->url) ? $image->subtype->url : '' }}">
          {!! ucfirst(getImageSubtypeInfo($image)['label']) !!}
        </a>
      </div>
    </div>
    @if ($image->character->location)
      <div class="home text-center">Location: {!! $image->character->location ? $image->character->location : 'None' !!}</div>
    @endif
  </div>

  <div class="trait-list">
    <h5 class="ruled-left text-700">Traits</h5>
    @if (config('lorekeeper.extensions.traits_by_category'))
      @php
        $traitgroup = $image->features()->get()->groupBy('feature_category_id');
      @endphp
      @if ($image->features()->count())
        @foreach ($traitgroup as $key => $group)
          <div class="pl-3 mb-2">
            @if ($key)
              <strong>{!! $group->first()->feature->category->displayName !!}:</strong>
            @else
              <strong>Miscellaneous:</strong>
            @endif
            @foreach ($group as $feature)
              <div class="pl-2 ml-md-2">{!! $feature->feature->displayName !!} @if ($feature->data)
                  ({{ $feature->data }})
                @endif
              </div>
            @endforeach
          </div>
        @endforeach
      @else
        <div>No traits listed.</div>
      @endif
    @else
      <div>
        <?php $features = $image->features()->with('feature.category')->get(); ?>
        @if ($features->count())
          @foreach ($features as $feature)
            <div>
              @if ($feature->feature->feature_category_id)
                <strong>{!! $feature->feature->category->displayName !!}:</strong>
                @endif {!! $feature->feature->displayName !!} @if ($feature->data)
                  ({{ $feature->data }})
                @endif
            </div>
          @endforeach
        @else
          <div>No traits listed.</div>
        @endif
      </div>
    @endif
  </div>

  @if ($character->image->titles->count() > 0)
    <div class="titles">
      <h5 class="ruled-left text-700">Titles</h5>
      {!! $character->image->displayTitles !!}
    </div>
  @endif

  <div class="art mt-3">
    <h5 class="ruled-left text-700"> Credits </h5>
    <div class="grid ji-center">
      <div class="flex">
        <h6 class="mr-2">Design</h6>
        @foreach ($image->designers as $designer)
          <div>{!! $designer->displayLink() !!}</div>
        @endforeach
      </div>

      <div class="flex">
        <h6 class="mr-2">Art</h6>
        @foreach ($image->artists as $artist)
          <div>{!! $artist->displayLink() !!}</div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="flex jc-center">
    {{-- <h5 class="ruled-left text-700"> Misc. </h5> --}}

    <div class="flex small jc-center gap-_5">
      <p style="text-align: end;"><strong>Uploaded: </strong>
        <br>
        {!! format_onlyDate($image->created_at, false) !!}
      </p>
      •
      <p><strong>Last Edited: </strong>
        <br>
        {!! pretty_date($image->updated_at) !!}
      </p>
    </div>
  </div>

  <div class="meta-info">
    <div class="badge badge-primary">Image #{{ $image->id }}</div>
    @if (!$image->character->is_myo_slot && !$image->is_valid)
      <div class="alert alert-danger">
        This version of this character is outdated, and only noted here for recordkeeping purposes. Do not use as an
        official
        reference.
      </div>
    @endif
  </div>
  @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
    <div class="admin">
      <details>
        <summary class="h5 ruled-left text-700">
          <i class="fas fa-caret-down"></i>
          Administrative
        </summary>
        <a
          href="#"
          class="btn btn-outline-info btn-sm edit-features"
          data-id="{{ $image->id }}"
        >
          <i class="fas fa-cog"></i>
          Edit Character
        </a>
        <a
          href="#"
          class="btn btn-outline-info btn-sm edit-credits"
          data-id="{{ $image->id }}"
        ><i class="fas fa-cog"></i> Edit Artists</a>
        {!! Form::open(['url' => 'admin/character/image/' . $image->id . '/settings']) !!}
        <div class="form-group">
          {!! Form::checkbox('is_visible', 1, $image->is_visible, ['class' => '']) !!}
          {!! Form::label('is_visible', 'Is Viewable', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If this is turned off, the image will not be visible by anyone without the Manage Masterlist power.') !!}
        </div>
        <div class="form-group">
          {!! Form::checkbox('is_valid', 1, $image->is_valid, ['class' => '']) !!}
          {!! Form::label('is_valid', 'Is Valid', ['class' => 'form-check-label ml-3']) !!} {!! add_help(
              'If this is turned off, the image will still be visible, but displayed with a note that the image is not a valid reference.'
          ) !!}
        </div>
        @if (config('lorekeeper.settings.enable_character_content_warnings'))
          <div class="form-group">
            {!! Form::label('Content Warnings') !!} {!! add_help(
                'These warnings will be displayed on the character\'s page. They are not required, but are recommended if the character contains sensitive content.'
            ) !!}
            {!! Form::text('content_warnings', null, [
                'class' => 'form-control',
                'id' => 'warningList',
                'data-init-value' => $image->editWarnings
            ]) !!}
          </div>
        @endif
        <div class="text-right">
          {!! Form::submit('Edit', ['class' => 'btn btn-primary mb-3']) !!}
        </div>
        {!! Form::close() !!}

        <div class="text-right">
          @if ($character->character_image_id != $image->id)
            <a
              href="#"
              class="btn btn-outline-info btn-sm active-image"
              data-id="{{ $image->id }}"
            >Set Active</a>
          @endif <a
            href="#"
            class="btn btn-outline-info btn-sm reupload-image"
            data-id="{{ $image->id }}"
          >Reupload Image</a> <a
            href="#"
            class="btn btn-outline-danger btn-sm delete-image"
            data-id="{{ $image->id }}"
          >Delete</a>
        </div>
      </details>
    </div>
  @endif
  @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
  @endif

  @include('widgets._character_warning_js')
</div>
