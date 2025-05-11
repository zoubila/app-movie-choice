// assets/js/loader.js

window.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');
    const content = document.getElementById('content');
    const findMovieBtn = document.getElementById('find-movie-btn');

    if (findMovieBtn && loader) {
        findMovieBtn.addEventListener('click', function () {
            loader.style.display = 'flex';
            content.style.display = 'none';
        });
    }

    // sécurité : cacher le loader quand tout est chargé
    window.addEventListener('load', function () {
        if (loader && content) {
            loader.classList.add('fade-out');
            setTimeout(() => {
                loader.style.display = 'none';
                content.style.display = 'block';
            }, 500);
        }
    });
});
