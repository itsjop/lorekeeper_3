tinymce.init({
selector: '#modal .wysiwyg',
height: 500,
menubar: false,
plugins: [
'advlist autolink lists link image charmap print preview anchor',
'searchreplace visualblocks code fullscreen',
'insertdatetime media table paste code help wordcount'
],
toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code',
content_css: [
'//www.tiny.cloud/css/codepen.min.css',
'{{ asset('css/vendor/app.css') }}',
'{{ asset('css/lorekeeper.css') }}'
]
});
