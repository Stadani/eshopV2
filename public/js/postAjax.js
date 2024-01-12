
function updateCommentsPerPage(perPage) {
    console.log('Updating comments per page:', perPage);
    $.ajax({
        type: 'GET',
        url: '/post/' + postSlug,
        data: {perPage: perPage},
        success: function (response) {
            console.log('Success');
            $('#commentContainer').html(response.forumItemsHTML);
            $('#paginationContainer').html(response.paginationHTML);
        }
    });
}

$(document).ready(function () {
    $('#commentsPerPageDropdown').on('change', function () {
        updateCommentsPerPage($(this).val());
    });
});

