new Vue({
    el: '#playlists',
    data: {
       playlists: [],
    },
    ready: function() {
        this.getPlaylists();
    },
    methods: {
        getPlaylists: function() {
            let self = this;
            this.$http.get('/child/playlists').then(function(response) {
                self.$set('playlists', response.data);
            });
        },
        filterPlaylists: function(event) {
            event.preventDefault();
            var search = $('#search').val();
            let self = this;
            this.$http.get('/child/playlists?search=' + search).then(function(response) {
                self.$set('playlists', response.data);
            }, (response) => {
                toastr.error(response.data);
            });
        }
    }
});
