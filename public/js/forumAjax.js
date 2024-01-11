

function updatePostsPerPage(perPage) {
    console.log('Updating posts per page:', perPage);
    $.ajax({
        type: 'GET',
        url: '/forum',
        data: {perPage: perPage},
        success: function (response) {
            console.log('Success', response);
            $('#forumContainer').html(response.forumItemsHTML);
            $('#paginationContainer').html(response.paginationHTML);
        }
    });
}

$(document).ready(function () {
    $('#postsPerPageDropdown').on('change', function () {
        updatePostsPerPage($(this).val());
    });
});

