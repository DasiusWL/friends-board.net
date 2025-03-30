

document.addEventListener("DOMContentLoaded", function () {
    const protectedLinks = document.querySelectorAll(".protected-link");
    const popup = document.getElementById("popup");

    protectedLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            popup.classList.add("active"); 
            setTimeout(() => {
                popup.classList.remove("active");
            }, 2000);
        });
    });
});