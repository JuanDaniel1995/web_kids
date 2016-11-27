var player;
var changeVideos = false;
var youtubeEvent;

$('a.page-scroll').bind('click', function(event) {
    event.preventDefault();
    var $anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top - 50)
    }, 1250, 'easeInOutExpo');
});

$(document).ready(function() {
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
});

function refreshPlaylist(event) {
    if (event.keyCode == 13) {
        changeVideos = true;
        getVideos(this.youtubeEvent);
    }
}

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '390',
        width: '640',
        playerVars:
        {
            autoplay: 1,
            controls: 1,
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange,
        }
    });
}

function onPlayerStateChange(event) {
    this.youtubeEvent = event;
    if (event.data == YT.PlayerState.PAUSED) changeVideos = false;
    if (event.data == YT.PlayerState.PAUSED && changeVideos) {
        getVideos(event);
    }
}

function getVideos(event) {
    var search = $('#search_playlists').val();
    var videosId = [];
    $.ajax({
        type: 'GET',
        url: '/child/playlists',
        data: {
            search: search,
        },
    }).done(function(data) {
        var videoId;
        $.each(data, function( index, item ) {
            videoId = item.url.split('/');
            videoId = videoId[videoId.length - 1];
            videosId.push(videoId);
        });
        if (videosId.length > 0) {
            event.target.loadPlaylist({
                playlist: videosId,
            });
        }
    });
}

function onPlayerReady(event) {
    this.youtubeEvent = event;
    getVideos(event);
}