function checkFields() {
    var body = document.getElementById('textBody').value;
    var rating = document.querySelector('input[name="rating"]:checked');
    var submitButton = document.getElementById('submitButton');

    if (body.trim() === '' || rating === null) {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    checkFields();

    document.getElementById('textBody').addEventListener('input', checkFields);
    var ratingInputs = document.querySelectorAll('input[name="rating"]');
    ratingInputs.forEach(function(input) {
        input.addEventListener('change', checkFields);
    });
});
