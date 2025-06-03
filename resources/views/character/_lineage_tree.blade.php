<div class="col mx-1">
    <div class="border-bottom mb-1">
        <span class="font-weight-bold {{ $max_depth == config('lorekeeper.lineage.lineage_depth') - 1 ? 'h4' : '' }}">
            {{ $parent }}
        </span>
        <br>
        @if ($max_depth == config('lorekeeper.lineage.lineage_depth') - 1)
            <a href="{{ $character ? $character->url : '#' }}" class="{{ $max_depth == config('lorekeeper.lineage.lineage_depth') - 1 ? 'h4' : '' }}">
                {!! $character ? '<img src="' . $character->image->thumbnailUrl . '" class=\'img-thumbnail\' alt=\'Thumbnail for ' . $character->fullName . '\' />' : '' !!}
                <br>
                {!! $character ? $character->fullName : 'Unkown' !!}
            </a>
        @else
            <a href="{{ $character ? $character->url : '#' }}" data-toggle="tooltip" data-placement="top"
                title="{{ $character ? '<img src="' . $character->image->thumbnailUrl . '" class=\'img-thumbnail\' alt=\'Thumbnail for ' . $character->fullName . '\' />' : '' }}">
                {!! $character ? $character->fullName : 'Unkown' !!}
            </a>
        @endif
    </div>

    @if ($max_depth > 0)
        <div class="row">
            @include('character._lineage_tree', [
                'character' => $character?->lineage?->father,
                'max_depth' => $max_depth - 1,
                'parent' => $parent . "'s Father",
            ])
            @include('character._lineage_tree', [
                'character' => $character?->lineage?->mother,
                'max_depth' => $max_depth - 1,
                'parent' => $parent . "'s Mother",
            ])
        </div>
    @endif
</div>
