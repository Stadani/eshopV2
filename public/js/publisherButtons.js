document.addEventListener('DOMContentLoaded', function() {
    var showAllPublishersButton = document.getElementById('showAllPublishers');
    var showLessPublishersButton = document.getElementById('showLessPublishers');

    showAllPublishersButton.addEventListener('click', function() {
        var additionalPublishers = document.querySelectorAll('.additionalPublishers');
        additionalPublishers.forEach(function(publisher) {
            publisher.style.display = 'block';
        });
        this.style.display = 'none';
        showLessPublishersButton.style.display = 'block';
    });

    showLessPublishersButton.addEventListener('click', function() {
        var additionalPublishers = document.querySelectorAll('.additionalPublishers');
        additionalPublishers.forEach(function(publisher) {
            publisher.style.display = 'none';
        });
        this.style.display = 'none';
        showAllPublishersButton.style.display = 'block';
    });
});
