document.addEventListener('DOMContentLoaded', function() {
    const thumbs = document.querySelectorAll('.video-thumb');
    const mainIframe = document.getElementById('yt-main-iframe');
    thumbs.forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            mainIframe.src = 'https://www.youtube.com/embed/' + this.dataset.key;
            mainIframe.title = this.dataset.title;
        });
    });
});