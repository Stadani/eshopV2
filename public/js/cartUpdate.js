$(document).ready(function() {
    $(".cartUpdate").change(function (e) {
        e.preventDefault();

        var element = $(this);
        var productId = element.closest("tr").data("id");
        var productQuantity = element.closest("tr").find(".quantity").val();

        $.ajax({
            url: updateCartRoute,
            method: "patch",
            data: {
                _token: CSRF_TOKEN,
                id: productId,
                quantity: productQuantity,
            },
            success: function (response) {
                window.location.reload();
            }
        });
    });
});
