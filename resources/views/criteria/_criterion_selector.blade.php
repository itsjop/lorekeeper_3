<div class="d-flex justify-content-between align-items-center mb-2">
  <div class="flex-grow-1 mr-2">
    {!! Form::select('criterion[#][id]', $criteria, null, [
        'class' => 'form-control criterion-select',
        'placeholder' => 'Reward Calculator'
    ]) !!}
  </div>
  <div>
    <button class="btn btn-danger delete-calc" type="button">
      <i class="fas fa-trash"></i>
    </button>
  </div>
</div>
<div class="form"> Select a reward calculator to see its options. </div>
