funcDefault = {
    loader: function (show) {
        $('.ajax-loader').remove();
        if (show === true) {
            $('body').prepend('<div class="ajax-loader"></div>');
        }
    },
    error: function (selector, data) {
        if ($(selector).length > 0) {
            if ($(selector).find('.alert.alert-danger').length > 0) {
                $(selector).find('.alert.alert-danger').remove();
            }

            $(selector).prepend('<div class="alert alert-danger">' + data + '</div>');

            setTimeout(function () {
                $(selector).find('.alert.alert-danger')
                    .fadeOut(1000, function () {
                        $(this).remove();
                    });
            }, 2500);
        }
    },
    keyup: {
        error: function () {
            $('.form-control.error, .form-item.error').on('keyup click focus', function () {
                $(this).removeClass('error');
            });
            $('.form-control.wrong, .form-item.wrong').on('keyup click focus', function () {
                $(this).removeClass('wrong');
            });
        }
    },
    lang: function () {
        $('.set-language').on('click', function(e){
            e.preventDefault();
            
            var url = $(this).data('url');
            var vals = {
                'lang': $(this).data('lang')
            };
            $.post(url, vals, function(data){
                if(data.status === true){
                    window.location.reload();
                }
            });
        });
    },
    select: function (target) {
        var rng, sel;
        if (document.createRange) {
            rng = document.createRange();
            rng.selectNode(target)
            sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(rng);
        } else {
            var rng = document.body.createTextRange();
            rng.moveToElementText(target);
            rng.select();
        }
    },
    init: function () {
        this.lang();
    }
};

$(document).ready(function () {
    //init func
    funcDefault.init();
});