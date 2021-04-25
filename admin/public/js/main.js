function ready(fn) {
    if (document.readyState != 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

ready(function () {
    //  CHECK ALL
    const input = document.querySelector('input[name="checkAll"]');
    input?.addEventListener("click", function () {

        if (!input.classList.contains("checked")) {
            document.querySelectorAll('.list-table-wp tbody tr td input[type="checkbox"]').forEach(item => item.setAttribute("checked", ""));
            input.classList.add("checked");
        } else {
            document.querySelectorAll('.list-table-wp tbody tr td input[type="checkbox"]').forEach(item => item.removeAttribute("checked"));
            input.classList.remove("checked");
        }

    });

    // EVENT SIDEBAR MENU
    document.querySelectorAll('#sidebar-menu .nav-item .nav-link .title').forEach(item => {
        item.insertAdjacentHTML('afterend', '<span class="fa fa-angle-down arrow"></span>');
    })
    var sidebar_menu = document.querySelectorAll('#sidebar-menu > .nav-item > .nav-link');
    sidebar_menu.forEach(item => {
        item.closest('li').querySelector('.sub-menu').style.display = "none";
    })
    sidebar_menu.forEach(item => {
        item.addEventListener('click', function () {
            const slideTag = item.closest('li').querySelector('.sub-menu');
            if (slideTag.style.display === "none") {
                slideDown(slideTag);
                return false;
            } else {
                slideUp(slideTag);
                return false;
            }
        });
    })


    // ONCHANGE UPLOAD_IMAGES
    show_upload_image = function () {
        var upload_image = document.getElementById("upload-thumb")
        if (upload_image.files && upload_image.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('upload-image').setAttribute('src', e.target.result)
            };
            reader.readAsDataURL(upload_image.files[0]);
        }
    }
    show_upload_multi_image = function () {
        var upload_image = document.getElementById("upload-thumb");
        if (upload_image.files) {
            let str_class_img = "";
            for (var i = 0; i < upload_image.files.length; i++) {
                str_class_img += "<img class='fl-left' id='upload-image-" + i + "'>";
                $('div#slider-thumb').html(str_class_img);
                let selector_img = "#upload-image-" + i;

                var reader = new FileReader();
                reader.onload = function (e) {
                    $(selector_img).attr('src', e.target.result);
                    console.log(selector_img);
                };
                reader.readAsDataURL(upload_image.files[i]);
            }

        }
    }
});

/* SLIDE UP */
let slideUp = (target, duration = 300) => {

    target.style.transitionProperty = 'height, margin, padding';
    target.style.transitionDuration = duration + 'ms';
    target.style.boxSizing = 'border-box';
    target.style.height = target.offsetHeight + 'px';
    target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    window.setTimeout(() => {
        target.style.display = 'none';
        target.style.removeProperty('height');
        target.style.removeProperty('padding-top');
        target.style.removeProperty('padding-bottom');
        target.style.removeProperty('margin-top');
        target.style.removeProperty('margin-bottom');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');
        //alert("!");
    }, duration);
}

/* SLIDE DOWN */
let slideDown = (target, duration = 300) => {

    target.style.removeProperty('display');
    let display = window.getComputedStyle(target).display;
    if (display === 'none') display = 'block';
    target.style.display = display;
    let height = target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.boxSizing = 'border-box';
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + 'ms';
    target.style.height = height + 'px';
    target.style.removeProperty('padding-top');
    target.style.removeProperty('padding-bottom');
    target.style.removeProperty('margin-top');
    target.style.removeProperty('margin-bottom');
    window.setTimeout(() => {
        target.style.removeProperty('height');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');
    }, duration);
}

