document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('title').addEventListener('blur', function () {
        validateForm();
    });

    document.getElementById('tags').addEventListener('blur', function () {
        validateForm();
    });
    document.getElementById('body').addEventListener('blur', function () {
        validateForm();
    });

    function validateForm() {
        var titleErr = document.getElementById('titleErr');
        var tagsrErr = document.getElementById('tagsErr');
        var bodyErr = document.getElementById('bodyErr');
        var serverErrCont = document.getElementById('serverErrCont');

        var title = document.getElementById('title').value.trim();
        var tags = document.getElementById('tags').value.trim();
        var body = document.getElementById('body').value.trim();

        if (serverErrCont.children.length === 0) {
            if (title === '') {
                titleErr.innerText = 'Title cannot be empty';
            } else {
                titleErr.innerText = '';
            }
            if (tags.length === 0) {
                tagsrErr.innerText = 'Tags cannot be empty';
            } else {
                tagsrErr.innerText = '';
            }

            if (body === '') {
                bodyErr.innerText = 'Body cannot be empty';
            } else {
                bodyErr.innerText = '';
            }


            titleErr.style.display = title === '' ? 'block' : 'none';
            tagsrErr.style.display = tags === '' ? 'block' : 'none';
            bodyErr.style.display = body === '' ? 'block' : 'none';
        }

    }
});
