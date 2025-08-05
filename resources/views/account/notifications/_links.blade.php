<script>
  $(document).ready(function() {
    $('.accept-link').on('click', function(e) {
      e.preventDefault();
      let $row = $(this).parent().parent().parent();
      let id = $(this).data('link-id');
      let notificationId = $row.find('.clear-notification').data('id');

      $.ajax({
        url: '{{ url('links/accept') }}/' + id,
        data: {
          _token: '{{ csrf_token() }}'
        },
        method: 'POST',
        success: function(data) {
          $.get("{{ url('notifications/delete') }}/" + notificationId, function(data) {
            $row.fadeOut(300, function() {
              $(this).remove();
            });
          });
        },
        error: function(data) {
          // location.reload();
        }
      });
    });

    $('.reject-link').on('click', function(e) {
      e.preventDefault();
      let $row = $(this).parent().parent().parent();
      let id = $(this).data('link-id');
      let notificationId = $row.find('.clear-notification').data('id');

      $.ajax({
        url: '{{ url('links/delete') }}/' + id,
        data: {
          _token: '{{ csrf_token() }}'
        },
        method: 'POST',
        success: function(data) {
          $.get("{{ url('notifications/delete') }}/" + notificationId, function(data) {
            $row.fadeOut(300, function() {
              $(this).remove();
            });
          });
        },
        error: function(data) {
          // location.reload();
        }
      });
    });
  });
</script>
