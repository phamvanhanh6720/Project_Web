function open_dropdown_menu() {
    let menu = document.getElementsByClassName('dropdown-menu')[0];
    if (menu.style.display === "none") {
        menu.style.display = "block";
    } else {
        menu.style.display = "none";
    }
};

function ready(fn) {
    if (document.readyState != 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

ready(() => {
    document.getElementById('main-content-wp')?.addEventListener('click', () => {
        let menu = document.getElementsByClassName('dropdown-menu')[0];
        if (menu.style.display === "block") {
            menu.style.display = "none";
        }
    });
})

