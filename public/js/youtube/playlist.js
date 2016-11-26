function updatePlaylist(youtube_id) {
    $.ajax({
        type: 'PUT',
        url: $('#sync').attr('data-url'),
        data: {
            youtube_id: youtube_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }).done(function(data) {
        toastr.success(data);
    }).fail(function(data) {
        toastr.error(data);
    });
}

$('#sync').bind('click', function(event) {
    event.preventDefault();
    gapi.load('client', initYoutubeApi);
});

function syncData() {
    var title = $('.panel-heading').text();
    var request = gapi.client.youtube.playlists.insert({
        part: 'snippet,status',
        resource: {
            snippet: {
                title: title,
                description: 'A private playlist created with the YouTube API'
            },
            status: {
                privacyStatus: 'private'
            }
        }
    });
    request.execute(function(response) {
        var result = response.result;
        if (result) {
            updatePlaylist(response.id);
        }
    });
}