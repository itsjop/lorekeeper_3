{!! Form::label(ucfirst(__('lorekeeper.subtypes')) . ' (Optional)') !!}
{!! Form::select('subtype_ids[]', $subtypes, $image->subtypes()?->pluck('subtype_id')->toArray(), [
    'class' => 'form-control',
    'id' => 'subtype',
    'multiple',
    'placeholder' => 'Select Subtype(s)',
]) !!}
