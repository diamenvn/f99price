require('./bootstrap');
require('./event');


usingTheme = function (name = 'default') {
    $wrapper = $('.wrapper');
    switch (name) {
        case 'white':
            $wrapper.addClass('wrapper--white');
            break;

        default:
            $wrapper.removeClass('wrapper--white').removeClass('wrapper--black');
            break;
    }
}


$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    $header = $('.header');
    if (scroll > 90 && !$header.hasClass('header--fixed')) {
        $header.addClass('header--fixed');
    } else if (scroll < 90) {
        $header.removeClass('header--fixed');
    }
});

number = function (evt) {
    var theEvent = evt || window.event;
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

animateCSS = (element, animation, prefix = 'animate__') =>
    // We create a Promise and return it
    new Promise((resolve, reject) => {
        const animationName = `${prefix}${animation}`;
        const node = document.querySelector(element);

        node.classList.add(`${prefix}animated`, animationName);

        // When the animation ends, we clean the classes and resolve the Promise
        function handleAnimationEnd(event) {
            event.stopPropagation();
            node.classList.remove(`${prefix}animated`, animationName);
            resolve('Animation ended');
        }

        node.addEventListener('animationend', handleAnimationEnd, { once: true });
    });



lib = {
    request: {
        get: function (url, callback, params = [], error = null) {
            axios.get(url + params)
                .then(function (response) {
                    callback(response.data);
                })
                .catch(function (er) {
                    if (!!error) {
                        error(er);
                    } else {
                        Notify.show.error(er);
                    }
                })
        },
        post: function (url, callback, params = [], error = null) {
            axios.post(url, params)
                .then(function (response) {
                    callback(response.data);
                })
                .catch(function (er) {
                    if (!!error) {
                        error(er);
                    } else {
                        console.log(er);
                        Notify.show.error(er);
                    }
                })
        }
    }
}

Notify = {
    show: {
        error: function (msg) {
            Notiflix.Notify.Failure(msg);
        },
        success: function (msg) {
            Notiflix.Notify.Success(msg);
        },
        confirm: function (callback, title = "Xác nhận", des = "Bạn có chắc chắn thực hiện thao tác này?", yes = "Có", no = "Không", rollback = undefined) {
            Notiflix.Confirm.Show(
                title, des, yes, no,
                function () { callback(); },
                function () { if (!!rollback) { rollback(); } }
            )
        }
    }
}

function error(er) {
    alert(er);
}