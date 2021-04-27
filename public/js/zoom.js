
"use strict";
document.addEventListener("DOMContentLoaded", function (event) {
    const image = document.getElementById("zoom");
    if (image === null) {
        return;
    }
    image.addEventListener('mousemove', function (e) {
        hoverImage.apply(e.target, [e]);
    });

    image.addEventListener('mouseout', function (e) {
        mouseOut.apply(e.target, [e]);
    });

    const element = document.getElementById("overlay");

    function hoverImage(event) {

        const dimensions = this.getBoundingClientRect();

        const x = event.clientX - dimensions.left;
        const y = event.clientY - dimensions.top;


        const xPercent = Math.round(100 / (dimensions.width / x));
        const yPercent = Math.round(100 / (dimensions.height / y));

        element.style.backgroundImage = "url('" + this.src + "')";
        element.style.backgroundPosition = (xPercent) + "%" + (yPercent) + "%";
        element.style.left = (this.width + 20) + "px";
        element.style.top = this.offsetTop + "px";
        element.style.display = "block";
    }

    function mouseOut() {
        element.style.display = "none";
    }

})