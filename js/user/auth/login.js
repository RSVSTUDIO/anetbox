funcUserAuthLogin = {
    scrollTop: function (id) {
        //$('html,body').stop().animate({scrollTop: $(id).offset().top}, 1000);
        jQuery.scrollTo(id, 1000);
    },
    scroll: function () {
        $('.scroller').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            funcUserAuthLogin.scrollTop(id);
        });
    },
    error: {
        reg: function () {
            $('#account-register-form .error').removeClass('error').addClass('wrong');
            var el = $('#account-register-form .wrong:first');
            if (el.length > 0) {
                funcUserAuthLogin.scrollTop(el);
            }
        },
        login: function () {
            $('#loginModal .form-control.error').removeClass('error').addClass('wrong');
            var el = $('#loginModal .form-control.wrong:first');
            if (el.length > 0) {
                $('#loginModal').modal('show');
            }
        },
    },
    toggle: {
        password: function () {
            $('#account-register-form .password_toggle').on('click', function (e) {
                e.preventDefault();

                var form = $(this).closest('#account-register-form');
                var pass = form.find('input[name="userpassword"]');

                if (pass.attr('type') === 'text') {
                    pass.prop('type', 'password');
                    $(this).html($(this).data('show'));
                } else {
                    pass.prop('type', 'text');
                    $(this).html($(this).data('hide'));
                }
            });
        }
    },
    register: {
        addSite: function () {
            $('#account-register-form .add-site').on('click', function (e) {
                e.preventDefault();
                var box = $(this).closest('#account-register-form').find('.site-items');
                var html = '<span></span><input type="text" name="site[]" value="" class="w424 form-item" maxlength="90" placeholder="http://yoursite.com">';

                box.append(html);

                if (box.find('.form-item').length > 2) {
                    $(this).closest('.add_p').remove();
                }
            });
        }
    },
    init: function () {
        this.scroll();
        this.error.reg();
        this.error.login();
        this.toggle.password();
        this.register.addSite();
        
        funcDefault.keyup.error();
    }
};

$(document).ready(function () {
    //init func
    funcUserAuthLogin.init();
});