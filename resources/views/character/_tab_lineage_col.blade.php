<div class="col mx-1">
    <div class="border-bottom mb-1">
        <span class="font-weight-bold">
            {{ $parent }}
        </span>
        <br>
        <a href="{{ $character ? $character->url : '#' }}" data-toggle="tooltip" data-placement="top"
            title="{{ $character ? '<img src="' . $character->image->thumbnailUrl . '" class=\'img-thumbnail\' alt=\'Thumbnail for ' . $character->fullName . '\' />' : '' }}">
            {!! $character ? $character->fullName : 'Unkown' !!}
        </a>
    </div>

    @if ($max_depth > 0)
        <div class="row">
            @include('character._tab_lineage_col', [
                'character' => $character ? ($character->lineage ? $character->lineage->father : null) : null,
                'max_depth' => $max_depth - 1,
                'parent' => 'Father',
            ])
            @include('character._tab_lineage_col', [
                'character' => $character ? ($character->lineage ? $character->lineage->mother : null) : null,
                'max_depth' => $max_depth - 1,
                'parent' => 'Mother',
            ])
        </div>
    @endif
</div>
