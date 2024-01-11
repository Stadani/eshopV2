function showImage(src) {
    document.getElementById('mainImage').src = src;
}
function showTrailer(url) {
    document.getElementById('mainTrailer').src = url;
}
function openMedia(evt, mediaName) {
    var i, tabcontent, tablinks;
    //hides all content
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    //removes active
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    //clicked element gets displayed
    document.getElementById(mediaName).style.display = "block";
    evt.currentTarget.className += " active";
}


