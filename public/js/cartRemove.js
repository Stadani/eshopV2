
$(document).ready(function() {
    $(".cartRemove").click(function (e) {
        e.preventDefault();

        var element = $(this);
        var productId = element.closest("tr").data("id");

        $.ajax({
            url: removeFromCartRoute,
            method: "DELETE",
            data: {
                _token: CSRF_TOKEN,
                id: productId
            },

            success: function (response) {
                window.location.reload();
            }
        });
    });
});
