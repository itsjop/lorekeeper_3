<p> This will reject the design approval request, which closes the request and disallows the user from editing it further. Any
  attached items and/or currency will be returned. </p>
{!! Form::open(['url' => 'admin/designs/edit/' . $request->id . '/reject']) !!}
<div class="form-group">
  {!! Form::label('staff_comments', 'Comment') !!} {!! add_help('Enter a comment for the user. They will see this on their request page.') !!}
  {!! Form::textarea('staff_comments', $request->staff_comments, ['id' => 'reject-box', 'class' => 'form-control wysiwyg']) !!}
</div>
<div class="text-right">
  {!! Form::submit('Reject Request', ['class' => 'btn btn-danger']) !!}
</div>
{!! Form::close() !!}

<script>
  setTimeout(() => {
    // TinyMCE configuration
    tinymce.init({
      selector: '.wysiwyg',
      license_key: 'gpl',
      height: 500,
      menubar: false,
      convert_urls: false,
      plugins: [
        'advlist forecolor fontselect fontsizeselect autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen spoiler',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect fontselect fontsizeselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | code',
      content_css: [
        '{{ asset('css/vendor/lorekeeper.css') }}'
      ],
      spoiler_caption: 'Toggle Spoiler',
      target_list: false,
      indent_before: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
        'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
      indent_after: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
        'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
      whitespace_elements: 'p pre script noscript style textarea video audio iframe object code',
    });
  }, 40);
</script>
