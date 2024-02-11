let stars = document.getElementsByClassName("star");
let output = document.getElementById("output");

function gfg(n) {
    remove();
    for (let i = 0; i < n; i++) {
        stars[i].classList.add("selected");
    }
    output.innerText = "Rating is: " + n + "/5";
}

function remove() {
    for (let i = 0; i < stars.length; i++) {
        stars[i].classList.remove("selected");
    }
}
