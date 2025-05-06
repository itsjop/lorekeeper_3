function loadModal(url, title) {
    $('#modal').find('.modal-body').html('');
    $('#modal').find('.modal-title').html(title);
    $('#modal').find('.modal-body').load(url, ( response, status, xhr ) => {
        if ( status === "error" ) {
            // Debug Mode
            // console.log('xhr', xhr)
            // $( "#modal" ).find('.modal-body').html( `Error:${xhr.status} ${xhr.responseText}` );
            $( "#modal" ).find('.modal-body').html( `Error:${xhr.status} ${xhr.statusText}` );
        }
        else {
            $('#modal [data-toggle=tooltip]').tooltip({html: true});
            $('#modal [data-toggle=toggle]').bootstrapToggle();
            $('#modal .cp').colorpicker();
        }
    });
    $('#modal').modal('show');
}
