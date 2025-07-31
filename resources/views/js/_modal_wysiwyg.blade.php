tinymce.init({
selector: '#modal .wysiwyg',
height: 500,
menubar: false,
plugins: [
'advlist autolink lists link image charmap print preview anchor',
'searchreplace visualblocks fullscreen',
'insertdatetime media table paste codeeditor help wordcount'
],
toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | codeeditor',
content_css: [ '//www.tiny.cloud/css/codepen.min.css', '{{ asset('css/app.css') }}', '{{ asset('css/vendor/lorekeeper.css') }}'],
indent_before: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
indent_after: 'h1,h2,h3,h4,h5,h6,blockquote,div,title,style,pre,script,td,th,ul,ol,li,dl,dt,dd,area,table,thead,' +
'tfoot,tbody,tr,section,article,hgroup,aside,figure,figcaption,option,optgroup,datalist',
whitespace_elements: 'p pre script noscript style textarea video audio iframe object code',

});
