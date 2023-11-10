
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.querySelector('.navbar_tgl_button');
    const dropdown = document.querySelector('.dropdown_navbar');

    btn.onclick = function () {
        dropdown.classList.toggle('open');
    }
    console.log("NavbarScript is running!");
});
