{!! Form::label(ucfirst(__('lorekeeper.subtypes')) . ' (Optional)') !!} @if ($isMyo)
  {!! add_help(
      'This will lock the slot into a particular ' .
          __('lorekeeper.subtype') .
          '. Leave it blank if you would like to give the user a choice, or not select a ' .
          __('lorekeeper.subtype') .
          '. The ' .
          __('lorekeeper.subtype') .
          ' must match the ' .
          __('lorekeeper.species') .
          ' selected above, and if no ' .
          __('lorekeeper.species') .
          ' is specified, the ' .
          __('lorekeeper.subtype') .
          ' will not be applied.',
  ) !!}
@endif
{!! Form::select('subtype_ids[]', $subtypes, null, ['class' => 'form-control', 'id' => 'subtype', 'placeholder' => 'Select Subtypes', 'multiple']) !!}
