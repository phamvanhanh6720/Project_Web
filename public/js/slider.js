var counter = 1;
setInterval(function () {
    document.getElementById('radio' + counter).checked = true;
    counter++;
    if (counter > 3) {
        counter = 1;
    }
}, 3000);

var x = 0;

function prev() {
    x = (x >= 25) ? (x - 25) : 175;
    let menu = document.getElementById("item_slides");
    menu.style.marginLeft = -x + '%';
}

function next() {
    x = (x <= 200) ? (x + 25) : 0;
    let menu = document.getElementById("item_slides");
    menu.style.marginLeft = -x + '%';
}