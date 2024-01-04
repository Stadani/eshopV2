document.addEventListener('DOMContentLoaded', function() {
    var resetButton = document.getElementById('resetFilters');

    resetButton.addEventListener('click', function() {
        // Reset text input
        var searchInput = document.querySelector('.searchbar');
        if (searchInput) {
            searchInput.value = '';
        }

        // Reset all checkboxes
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });

        // Reset select elements
        var selects = document.querySelectorAll('select');
        selects.forEach(function(select) {
            select.value = '';
        });

        // Submit the form after reset
        var form = document.querySelector('form[action="/list"]');
        if (form) {
            form.submit();
        }
    });
});
