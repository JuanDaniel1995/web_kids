$('#sync').bind('click', function(event) {
    event.preventDefault();
    gapi.load('client', initYoutubeApi);
});

function syncData() {
    $.ajax({
        type: 'GET',
        url: $('#sync').attr('data-url'),
    }).done(function(data) {
        video_id = data.video.url.split('/');
        syncPlaylistVideo(video_id[video_id.length - 1], data.playlist.youtube_id);
    }).fail(function(data) {
        toastr.error('No se ha podido sincronizar');
    });
}

function syncPlaylistVideo(video_id, playlist_id) {
      var details = {
        videoId: video_id,
        kind: 'youtube#video'
      }
      var request = gapi.client.youtube.playlistItems.insert({
        part: 'snippet',
        resource: {
          snippet: {
            playlistId: playlist_id,
            resourceId: details
          }
        }
      });
      request.execute(function(response) {
        var result = response.result;
        if (result) {
            toastr.success('Se ha sincronizado exitosamente');
        } else
            toastr.success('Se ha sincronizado exitosamente');
      });
    }