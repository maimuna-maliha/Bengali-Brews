// assets/js/script.js

document.addEventListener("DOMContentLoaded", function () {
    console.log("Custom script loaded!");

    // Example: Highlight active menu link
    let currentPath = window.location.pathname;
    let menuLinks = document.querySelectorAll("nav a");

    menuLinks.forEach(link => {
        if (link.href.includes(currentPath)) {
            link.classList.add("active-link");
        }
    });
});
