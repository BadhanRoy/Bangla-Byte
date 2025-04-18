document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const navLeft = document.querySelector(".nav-left");

    hamburger.addEventListener("click", function () {
        navLeft.style.display = navLeft.style.display === "flex" ? "none" : "flex";
    });
});