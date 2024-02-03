<div class="col mx-1">
    <div class="border-bottom mb-1">
        <span class="font-weight-bold">
            {{ $parent }}
        </span>
        <br>
        <a href="{{ $character ? $character->url : '#' }}" data-toggle="tooltip" data-placement="top"
            title="{{ $character ? '<img src="' . $character->image->thumbnailUrl . '" class=\'img-thumbnail\' alt=\'Thumbnail for ' . $character->fullName . '\' />' : '<i class=\'fas fa-question-circle\'></i>' }}">
            {!! $character ? $character->fullName : 'Unkown' !!}
        </a>
    </div>

    @if ($max_depth > 0)
        <div class="row">
            @include('character._tab_lineage_col', [
                'character' => $character?->lineage?->father,
                'max_depth' => $max_depth - 1,
                'parent' => $parent . "'s Father",
            ])
            @include('character._tab_lineage_col', [
                'character' => $character?->lineage?->mother,
                'max_depth' => $max_depth - 1,
                'parent' => $parent . "'s Mother",
            ])
        </div>
    @endif
</div>
