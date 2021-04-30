function ready(fn) {
    if (document.readyState != 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

ready(() => {
    //  SCROLL TOP
    window.addEventListener("scroll", function (e) {
        const buttonToTop = this.document.getElementById('btn-top');

        if (document.body.getBoundingClientRect().top != 0) {
            buttonToTop.style = "transition: opacity 400ms;";
        } else {
            buttonToTop.style = "opacity: 0";
        }
    });
    document.getElementById('btn-top').addEventListener("click", function () {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });

    // CHOOSE NUMBER ORDER
    var value = parseInt(document.getElementById('num-order')?.getAttribute('value'));

    document.getElementById('plus')?.addEventListener("click", function () {
        value++;
        document.getElementById('num-order').setAttribute('value', value);
        // update_href(value);
    });
    document.getElementById('minus')?.addEventListener("click", function () {
        if (value > 1) {
            value--;
            document.getElementById('num-order').setAttribute('value', value);
        }
        // update_href(value);
    });

    //  MAIN MENU
    document.querySelector('#category-product-wp .list-item > li')?.querySelector('.sub-menu').insertAdjacentHTML("afterend", '<i class="fa fa-angle-right arrow" aria-hidden="true"></i>');

    document.querySelector('#btn-respon i').addEventListener('click', function (event) {
        var site = document.querySelector('#site');


        if (!site.classList.contains('show-respon-menu')) {
            site.classList.add('show-respon-menu');
        } else {
            site.classList.remove('show-respon-menu');
        }

    });

    document.querySelector('#container').addEventListener("click", function (e) {
        const btnButton = document.querySelector('#btn-respon i');
        if (e.target === btnButton) return;
        if (site.classList.contains('show-respon-menu')) {
            site.classList.remove('show-respon-menu');
            return false;
        }
    });

    //  MENU RESPON
    document.querySelector('#main-menu-respon li .sub-menu').insertAdjacentHTML('afterend', `<span class="fa fa-angle-right arrow"></span>`);
    const arrow = document.querySelector('#main-menu-respon li .arrow');
    arrow.addEventListener("click", function (e) {
        const parent = arrow.closest('li');
        if (parent.classList.contains('open')) {
            parent.classList.remove('open');
        } else {
            parent.classList.add('open');
        }
    });
});

