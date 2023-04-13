$(function () {
    $('.btn-login-js').click(function () {
        login($(this));
    });

    $('.btn-register-js').click(function () {
        register($(this));
    });

    $('.login').on('keydown', function (e) {
        if (e.key === "Enter") {
            login($(e.target));
        }
    });

    $(document).on('click', '.click-remove-ajax', function() {
        href = $(this).attr('data-href') || $(this).attr('href');

        Notify.show.confirm(function() {
            lib.send.post(href, function(res) {
                if (res.success){
                    Notify.show.success(res.msg);
                    window.location.reload();
                }else{
                    Notify.show.error(res.msg);
                }
                Notiflix.Loading.Remove();
            });
        });
    });
});

var login = function (self) {
    form = self.closest('form');
    username = form.find('input[name="username"]');
    password = form.find('input[name="password"]');
    if (!!!username.val()) {
        Notify.show.error('Vui lòng điền tên tài khoản');
        return;
    }

    if (!!!password.val()) {
        Notify.show.error('Vui lòng điền mật khẩu');
        return;
    }
    form.submit();
}

var register = function (self) {
    form = self.closest('form');
    username = form.find('input[name="username"]');
    email = form.find('input[name="email"]');
    password = form.find('input[name="password"]');
    rePassword = form.find('input[name="re-password"]');

    if (!!!username.val()) {
        Notify.show.error('Vui lòng điền tên tài khoản');
        return;
    }

    if (!!!password.val()) {
        Notify.show.error('Vui lòng điền mật khẩu');
        return;
    }

    if (password.val() != rePassword.val()) {
        Notify.show.error('Nhập lại mật khẩu không chính xác');
        return;
    }

    if (password.val().length < 6) {
        Notify.show.error('Mật khẩu không được ngắn hơn 6 kí tự');
        return;
    }

    if (!email.val()) {
        Notify.show.error('Email không được bỏ trống');
        return;
    }
    form.submit();
}