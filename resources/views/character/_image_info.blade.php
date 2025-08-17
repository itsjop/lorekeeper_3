{{-- Image Data --}}
<div class="col-md-5 d-flex">
  <div class="w-100">
    <div class="card character-bio w-100">
      <div class="card-header">
        <ul class="nav nav-tabs flex gap-_5 card-header-tabs">
          <li class="nav-item">
            <a
              class="nav-link active"
              id="infoTab-{{ $image->id }}"
              data-bs-toggle="tab"
              href="#info-{{ $image->id }}"
              role="tab"
            >Info</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" id="notesTab-{{ $image->id }}" data-bs-toggle="tab" href="#notes-{{ $image->id }}" role="tab">Notes</a>
          </li> --}}
          <li class="nav-item">
            <a
              class="nav-link"
              id="creditsTab-{{ $image->id }}"
              data-bs-toggle="tab"
              href="#credits-{{ $image->id }}"
              role="tab"
            >Credits</a>
          </li>
          {{-- @if (isset($showMention) && $showMention)
            <li class="nav-item">
              <a class="nav-link" id="mentionTab-{{ $image->id }}" data-bs-toggle="tab" href="#mention-{{ $image->id }}" role="tab">Mention</a>
          </li>
          @endif --}}
          @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
            <li class="nav-item">
              <a
                class="nav-link"
                id="settingsTab-{{ $image->id }}"
                data-bs-toggle="tab"
                href="#settings-{{ $image->id }}"
                role="tab"
              ><i class="fas fa-cog"></i></a>
            </li>
          @endif
        </ul>
      </div>
      <div class="card-body tab-content ">
        <div class="tab-pane fade show active" id="info-{{ $image->id }}">
          <div class="info-tab">
            <div class="quick-info">
              <h5 class="ruled-left text-600">{!! $image->species_id ? $image->species->displayName : 'None' !!}</h5>
              <div class="flex gap-_5 jc-center">
                <div class="rarity flex no-break">{!! $image->rarity_id ? $image->rarity->displayName : 'None' !!} </div>
                <img src="{{ asset('images/subtypes/badges/' . getSubtypeInfo($character->image->subtype_id) . '.png') }}"
                  style="height: 1.5em; margin-right: 0.1em;"
                >
                <div class="palate flex">
                  <a href="{{ $image->subtype->url }}">
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

            @if ($image->titles->count() > 0)
              <div class="titles">
                <h5 class="ruled-left text-700">Titles</h5>
                {!! $image->displayTitles !!}
              </div>
            @endif

            <div class="small">
              <h5 class="ruled-left text-700">Misc.</h5>
              <div class="flex jc-center gap-_5">
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
              @if (!$image->character->is_myo_slot && !$image->is_valid)
                <div class="alert alert-danger">
                  This version of this character is outdated, and only noted here for recordkeeping purposes. Do not use as an
                  official
                  reference.
                </div>
              @endif
              @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
                <div class="">
                  <a
                    href="#"
                    class="btn btn-outline-info btn-sm edit-features"
                    data-id="{{ $image->id }}"
                  >
                    <i class="fas fa-cog"></i>
                    Edit
                  </a>
                </div>
              @endif
            </div>
          </div>
        </div>

        {{-- Image notes --}}
        <div class="tab-pane fade" id="notes-{{ $image->id }}">
          <div class="badge badge-primary">Image #{{ $image->id }}</div>

          @if ($image->parsed_description)
            <div class="parsed-text imagenoteseditingparse">{!! $image->parsed_description !!}</div>
          @else
            <div class="imagenoteseditingparse">No additional notes given.</div>
          @endif
          @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
            <div class="mt-3">

              <a
                href="#"
                class="btn btn-outline-info btn-sm edit-notes"
                data-id="{{ $image->id }}"
              >
                <i class="fas fa-cog"></i> Edit</a>
            </div>
          @endif
        </div>

        {{-- Image credits --}}
        <div class="tab-pane fade" id="credits-{{ $image->id }}">
          <div class="badge badge-primary">Image #{{ $image->id }}</div>
          <div class="row no-gutters mb-2">
            <div class="p-0 col-lg-4 col-4">
              <h5>Design</h5>
            </div>
            <div class="p-0 col-lg-8 col-8">
              @foreach ($image->designers as $designer)
                <div>{!! $designer->displayLink() !!}</div>
              @endforeach
            </div>
          </div>
          <div class="row no-gutters">
            <div class="p-0 col-lg-4 col-4">
              <h5>Art</h5>
            </div>
            <div class="p-0 col-lg-8 col-8">
              @foreach ($image->artists as $artist)
                <div>{!! $artist->displayLink() !!}</div>
              @endforeach
            </div>
          </div>

          @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
            <div class="mt-3">
              <a
                href="#"
                class="btn btn-outline-info btn-sm edit-credits"
                data-id="{{ $image->id }}"
              ><i class="fas fa-cog"></i> Edit</a>
            </div>
          @endif
        </div>

        @if (isset($showMention) && $showMention)
          {{-- Mention This tab --}}
          <div class="tab-pane fade" id="mention-{{ $image->id }}">
            In the rich text editor:
            <div class="alert alert-secondary">
              [character={{ $character->slug }}]
            </div>
            @if (!config('lorekeeper.settings.wysiwyg_comments'))
              In a comment:
              <div class="alert alert-secondary">
                [{{ $character->fullName }}]({{ $character->url }})
              </div>
            @endif
            <hr>
            <div class="my-2">
              <strong>For Thumbnails:</strong>
            </div>
            In the rich text editor:
            <div class="alert alert-secondary">
              [charthumb={{ $character->slug }}]
            </div>
            @if (!config('lorekeeper.settings.wysiwyg_comments'))
              In a comment:
              <div class="alert alert-secondary">
                [![Thumbnail of {{ $character->fullName }}]({{ $character->image->thumbnailUrl }})]({{ $character->url }})
              </div>
            @endif
          </div>
        @endif

        @if (Auth::check() && Auth::user()->hasPower('manage_characters'))
          <div class="tab-pane fade" id="settings-{{ $image->id }}">
            <div class="badge badge-primary">Image #{{ $image->id }}</div>
            {!! Form::open(['url' => 'admin/character/image/' . $image->id . '/settings']) !!}
            <div class="form-group">
              {!! Form::checkbox('is_visible', 1, $image->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
              {!! Form::label('is_visible', 'Is Viewable', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If this is turned off, the image will not be visible by anyone without the Manage Masterlist power.') !!}
            </div>
            <div class="form-group">
              {!! Form::checkbox('is_valid', 1, $image->is_valid, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
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
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@include('widgets._character_warning_js')
