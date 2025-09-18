function loadModal(url, title) {
  $('#modal').find('.modal-body').html('');
  $('#modal').find('.modal-title').html(title);
  $('#modal').find('.modal-body').load(url, ( response, status, xhr ) => {
    if ( status === "error" )  $( "#modal" ).find('.modal-body').html( response );
    else {
      $('#modal [data-toggle=tooltip]').tooltip({html: true});
      $('#modal [data-toggle=toggle]').bootstrapToggle();
      $('#modal .cp').colorpicker();
    }
  });
  $('#modal').modal('show');
}
