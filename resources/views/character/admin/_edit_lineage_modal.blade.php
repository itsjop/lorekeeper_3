{!! Form::open(['url' => 'admin/'. ($isMyo ? 'myo/'.$character->id : 'character/'.$character->slug) .'/lineage']) !!}
    <div class="alert alert-warning">Custom ancestor names are only used when there is no live character ID set for that ancestor. DO NOT use it if there is no ancestor, leave it blank. Ancestor names and "unknown"s will be generated automatically.</div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('father_id', 'Father') !!}
                {!! Form::select('father_id', $characterOptions, $character->lineage ? $character->lineage->father_id : null, ['class' => 'form-control character-select', 'placeholder' => 'Unknown']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('father_name', 'Father Name') !!}
                {!! Form::text('father_name', $character->lineage ? $character->lineage->father_name : null, ['class' => 'form-control', 'placeholder' => 'Unknown']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            {!! Form::label('mother_id', 'Mother') !!}
            {!! Form::select('mother_id', $characterOptions, $character->lineage ? $character->lineage->mother_id : null, ['class' => 'form-control character-select', 'placeholder' => 'Unknown']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('mother_name', 'Mother Name') !!}
            {!! Form::text('mother_name', $character->lineage ? $character->lineage->mother_name : null, ['class' => 'form-control', 'placeholder' => 'Unknown']) !!}
        </div>
    </div>

    {{-- collapse for custom ancestry --}}
    <div class="card mt-3">
        <div class="card-header" data-toggle="collapse" data-target="#customAncestry" aria-expanded="false" aria-controls="customAncestry">
            <h2 class="h3">
                <i class="fas fa-chevron-down"></i> Custom Ancestry
            </h2>
        </div>
        <div class="collapse" id="customAncestry">
            <div class="card card-body">
                <div class="alert alert-info">
                    Custom ancestry is used to assign characters grandparents etc. when father / mother should remain unknown. This is useful for characters who are not related to any other characters, but still need to be assigned a lineage.
                    Relational ancestry will always take precedent over custom ancestry, when available.
                    <br><br>
                    <strong>NOTE:</strong> You may only create custom ancestry up to the lineage_depth config option.
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::label('ancestor_id', 'Ancestor') !!}
                        {!! Form::select('ancestor_id', $characterOptions, null, ['class' => 'form-control character-select', 'placeholder' => 'Unknown']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('ancestor_name', 'Ancestor Name') !!}
                        {!! Form::text('ancestor_name', null, ['class' => 'form-control', 'placeholder' => 'Unknown']) !!}
                    </div>
                </div>
                {{-- ancestor depth form field --}}
                <div class="form-group">
                    {!! Form::label('ancestor_depth', 'Ancestor Depth') !!}
                    {!! Form::number('ancestor_depth', 1, ['class' => 'form-control', 'min' => 1, 'max' => config('lorekeeper.lineage.lineage_depth') - 1]) !!}
                    <p>
                        Ancestry depth determines the depth of the ancestor. For example, if you want to assign a grandparent, the depth would be 1.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-right">
        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}
<script>
    $(document).ready(function() {
        $('.character-select').selectize();
    });
</script>
