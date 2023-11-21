document.addEventListener('DOMContentLoaded', function() {
    const btn = document.querySelector('.navbar_tgl_button');
    const dropdown = document.querySelector('.dropdown_navbar');

    btn.onclick = function () {
        dropdown.classList.toggle('open');
    }

    console.log("NavbarScript is running!");

    function closeDropdown() {
        dropdown.classList.remove('open');
    }

    window.addEventListener('resize', function () {
        closeDropdown();
    });

    document.addEventListener('click', function(event) {
        const isDropdownClicked = event.target.closest('.dropdown_navbar');
        const isNavbarTogglerClicked = event.target.closest('.navbar_tgl_button');

        if (!isDropdownClicked && !isNavbarTogglerClicked) {
            closeDropdown();
        }
    });
});
