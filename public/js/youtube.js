function onStart() {
    gapi.client.init({
        apiKey: 'AIzaSyA6eIVHBsy0mpUvQRXV4qoLkf1h4XohM04',
        clientId: '271522147032-mr7j98aqq1pae678uvmi0jetfm9ot7oa.apps.googleusercontent.com',
        scope: 'https://www.googleapis.com/auth/youtube',
        response_type: 'token',
        prompt: 'consent',
    }).then(function(response) {
        gapi.auth2.getAuthInstance().signIn();
        onLoad();
    });
};

$('#sync').bind('click', function(event) {
    event.preventDefault();
    gapi.load('client', onStart);
});

function onLoad() {
    gapi.client.load('youtube', 'v3', function() {
        syncPlaylist();
    });
}

function syncPlaylist() {
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