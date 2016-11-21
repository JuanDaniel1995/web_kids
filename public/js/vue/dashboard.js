Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#app-layout',
    data: {
       videos: [],
    },
    ready: function() {
        this.getVideos();
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
            var search = $('#search').val();
            let self = this;
            this.$http.get('/child/videos?search=' + search).then(function(response) {
                self.$set('videos', response.data);
            });
        }
    }
});
