@if (Auth::check())
  @if (Auth::user()->settings->show_image_blocks)
    {!! Form::open([
        'url' => 'account/blocked-images/block/' . base64_encode(urlencode(get_class($object))) . '/' . $object->id
    ]) !!}
    {!! Form::submit(checkImageBlock($object, Auth::user()) ? 'Unblock Image' : 'Block Image', [
        'class' => 'btn btn-success btn-sm ' . (isset($float) && $float ? 'float-right' : '')
    ]) !!}
    {!! Form::close() !!}
  @endif
@endif
