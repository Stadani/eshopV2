document.getElementById('showMore').addEventListener('click', function () {
    var hiddenElements = document.querySelectorAll('.gameSeriesCards .hidden');
    hiddenElements.forEach(function (el) {
        el.classList.replace('hidden', 'shown');
    });
    this.style.display = 'none';
    document.getElementById('showLess').style.display = 'block';
});

document.getElementById('showLess').addEventListener('click', function () {
    var shownElements = document.querySelectorAll('.gameSeriesCards .shown');
    shownElements.forEach(function (el) {
        el.classList.replace('shown', 'hidden');
    });
    this.style.display = 'none';
    document.getElementById('showMore').style.display = 'block';
});
