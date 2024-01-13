var currentPerPage;
var currentPage;

$(document).ready(function() {
    // Tag filtering
    $('.form-check-input').change(function() {
        var selectedTags = [];
        $('.form-check-input:checked').each(function() {
            selectedTags.push($(this).val());
        });

        updateContent(selectedTags, currentPerPage, currentPage);
    });

    // Posts per page
    $('#postsPerPageDropdown').on('change', function () {
        currentPerPage = $(this).val();
        updateContent([], currentPerPage, currentPage);
    });

    // Function to update content
    function updateContent(tags, perPage, page) {
        $.ajax({
            url: '/forum',
            type: 'GET',
            data: {
                tag: tags,
                perPage: perPage,
                page: page
            },
            success: function (response) {
                $('#forumContainer').html(response.forumItemsHTML);
                $('#paginationContainer').html(response.paginationHTML);
            }
        });
    }
});
