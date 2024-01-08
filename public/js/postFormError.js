 document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('title').addEventListener('blur', function () {
        validateForm();
    });

    document.getElementById('body').addEventListener('blur', function () {
    validateForm();
});

    function validateForm() {
    var title = document.getElementById('title').value.trim();
    var body = document.getElementById('body').value.trim();
    var isValid = true;

    if (title === '') {
    document.getElementById('titleErr').innerText = 'Title cannot be empty';
    isValid = false;
} else {
    document.getElementById('titleErr').innerText = '';
}

    if (body === '') {
    document.getElementById('bodyErr').innerText = 'Body cannot be empty';
    isValid = false;
} else {
    document.getElementById('bodyErr').innerText = '';
}
        titleErr.style.display = title === '' ? 'block' : 'none';
        bodyErr.style.display = body === '' ? 'block' : 'none';

    return isValid;
}
});
