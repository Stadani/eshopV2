document.addEventListener('DOMContentLoaded', function() {
    var showAllDevelopersButton = document.getElementById('showAllDevelopers');
    var showLessDevelopersButton = document.getElementById('showLessDevelopers');

    showAllDevelopersButton.addEventListener('click', function() {
        var additionalDevelopers = document.querySelectorAll('.additionalDevelopers');
        additionalDevelopers.forEach(function(developer) {
            developer.style.display = 'block';
        });
        this.style.display = 'none';
        showLessDevelopersButton.style.display = 'block';
    });

    showLessDevelopersButton.addEventListener('click', function() {
        var additionalDevelopers = document.querySelectorAll('.additionalDevelopers');
        additionalDevelopers.forEach(function(developer) {
            developer.style.display = 'none';
        });
        this.style.display = 'none';
        showAllDevelopersButton.style.display = 'block';
    });
});
