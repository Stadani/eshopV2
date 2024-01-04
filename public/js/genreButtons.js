document.addEventListener('DOMContentLoaded', function() {
    var showAllGenresButton = document.getElementById('showAllGenres');
    var showLessGenresButton = document.getElementById('showLessGenres');

    showAllGenresButton.addEventListener('click', function() {
        var additionalGenres = document.querySelectorAll('.additionalGenres');
        additionalGenres.forEach(function(genre) {
            genre.style.display = 'block';
        });
        this.style.display = 'none';
        showLessGenresButton.style.display = 'block';
    });

    showLessGenresButton.addEventListener('click', function() {
        var additionalGenres = document.querySelectorAll('.additionalGenres');
        additionalGenres.forEach(function(genre) {
            genre.style.display = 'none';
        });
        this.style.display = 'none';
        showAllGenresButton.style.display = 'block';
    });
});
