$(document).ready(function () {
    // Reset button click event
    $('#resetFiltersButton').click(function () {
        // Clear all checkboxes
        $('input[type=checkbox]').prop('checked', false);

        // Reset ordering dropdown to default
        $('#ordering').val('');

        // Submit the form to reset the filters
        $('#filterForm').submit();
    });
});
