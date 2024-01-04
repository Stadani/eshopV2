document.addEventListener('DOMContentLoaded', function() {
    var showAllButton = document.getElementById('showAllPlatforms');
    var showLessButton = document.getElementById('showLessPlatforms');

    showAllButton.addEventListener('click', function() {
        var additionalPlatforms = document.querySelectorAll('.additionalPlatforms');
        additionalPlatforms.forEach(function(platform) {
            platform.style.display = 'block';
        });
        this.style.display = 'none';
        showLessButton.style.display = 'block';
    });

    showLessButton.addEventListener('click', function() {
        var additionalPlatforms = document.querySelectorAll('.additionalPlatforms');
        additionalPlatforms.forEach(function(platform) {
            platform.style.display = 'none';
        });
        this.style.display = 'none';
        showAllButton.style.display = 'block';
    });
});
