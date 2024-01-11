var modal = document.getElementById('description-modal');
var btn = document.getElementById('read-more-btn');
//returns array of all classes in document
var span = document.getElementsByClassName('close')[0];

btn.onclick = function () {
    modal.style.display = 'flex';
}


span.onclick = function () {
    modal.style.display = 'none';
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
