new Vue({
    el: '#app-layout',
    data: {
       videos: [],
       playlists: [],
    },
    ready: function() {
        this.getVideos();
        this.getPlaylists();
    },
    methods: {
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
