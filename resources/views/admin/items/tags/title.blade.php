<p>Custom titles cannot be applied by users. They are only applied by administrators.</p>

<div class="form-group">
    {!! Form::label('type', 'Type:', ['class' => 'form-control-label']) !!}
    {!! Form::select(
        'type',
        [
            'all' => 'All Titles Applied',
            'choice' => 'User Chooses One',
        ],
        $tag->getData()['type'],
        ['class' => 'form-control'],
    ) !!}
</div>

<div class="form-group">
    {!! Form::label('title_ids', 'Titles:', ['class' => 'form-control-label']) !!}
    {!! Form::select('title_ids[]', $tag->getEditData()['titles'], $tag->getData()['title_ids'], ['class' => 'form-control selectize', 'multiple']) !!}
</div>

<script>
    $(document).ready(function() {
        $('.selectize').selectize();
    });
</script>
