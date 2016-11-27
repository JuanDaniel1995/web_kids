new Vue({
    el: '#app-layout',
    data: {
       videos: [],
       playlists: [],
    },
    ready: function() {
        //gapi.load('client', this.initYoutubeApi);
        this.getVideos();
        this.getPlaylists();
    },
    methods: {
        initYoutubeApi: function() {
            gapi.client.init({
                apiKey: 'AIzaSyA6eIVHBsy0mpUvQRXV4qoLkf1h4XohM04',
                clientId: '271522147032-mr7j98aqq1pae678uvmi0jetfm9ot7oa.apps.googleusercontent.com',
                scope: 'https://www.googleapis.com/auth/youtube',
            }).then(function(response) {
                gapi.client.load('youtube', 'v3', function() {
                    var requestOptions = {
                        playlistId: 'PL5ffIpK93ol75O7602Asg9fEZJxq5W6k8',
                        part: 'snippet',
                        maxResults: 10
                    };
                    var request = gapi.client.youtube.playlistItems.list(requestOptions);
                    request.execute(function(response) {
                        console.log(response);
                    });
                });
            });
        },
        getVideos: function() {
            let self = this;
            this.$http.get('/child/videos').then(function(response) {
                self.$set('videos', response.data);
            });
        },
        filterVideos: function(event) {
            event.preventDefault();
            var search = $('#search_videos').val();
            let self = this;
            this.$http.get('/child/videos?search=' + search).then(function(response) {
                self.$set('videos', response.data);
            }, (response) => {
                toastr.error(response.data);
            });
        },
        getPlaylists: function() {
            let self = this;
            this.$http.get('/child/playlists').then(function(response) {
                self.$set('playlists', response.data);
            });
        },
        filterPlaylists: function(event) {
            var search = $('#search_playlists').val();
            let self = this;
            this.$http.get('/child/playlists?search=' + search).then(function(response) {
                self.$set('playlists', response.data);
            }, (response) => {
                toastr.error(response.data);
            });
        }
    }
});
