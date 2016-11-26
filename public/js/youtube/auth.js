function initYoutubeApi() {
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

function onLoad() {
    gapi.client.load('youtube', 'v3', function() {
        syncData();
    });
}