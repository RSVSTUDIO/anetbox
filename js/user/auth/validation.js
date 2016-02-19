$(document).ready(function(){
// ====================================================== //

    var jVal = {
        'fullName' : function() {

            $('body').append('<div id="nameInfo" class="info"></div>');

            var nameInfo = $('#nameInfo');
            var ele = $('#fullname');
            var pos = ele.offset();

            nameInfo.css({
                top: pos.top +4 ,
                left: pos.left -  153
            });

            if(ele.val().length < 4) {
                jVal.errors = true;
                nameInfo.removeClass('correct').addClass('error').show();
                $('.fullname').addClass('wrong').html(ele.data('error'));
                ele.removeClass('normal').addClass('wrong');
            } else {
                nameInfo.removeClass('error').addClass('correct').html('').show();
                $('.fullname').removeClass('wrong').html(ele.data('info')).show();
                ele.removeClass('wrong').addClass('normal');
            }
        },
        'password' : function() {

            $('body').append('<div id="passwordInfo" class="info"></div>');

            var passwordInfo = $('#passwordInfo');
            var ele = $('#password');
            var pos = ele.offset();

            passwordInfo.css({
                top: pos.top + 6 ,
                left: pos.left -  153
            });

            if(ele.val().length < 6) {
                jVal.errors = true;
                passwordInfo.removeClass('correct').addClass('error').show();
                $('.pass_lab').addClass('wrong').html(ele.data('error'));
                ele.removeClass('normal').addClass('wrong');
            } else {
                passwordInfo.removeClass('error').addClass('correct').html('').show();
                $('.pass_lab').removeClass('wrong').html('').show();
                ele.removeClass('wrong').addClass('normal');
            }
        },

        'email' : function() {

            $('body').append('<div id="emailInfo" class="info"></div>');

            var emailInfo = $('#emailInfo');
            var ele = $('#email');
            var pos = ele.offset();

            emailInfo.css({
                top: pos.top + 5 ,
                left: pos.left -  153
            });

            var patt = /^.+@.+[.].{2,}$/i;

            if(!patt.test(ele.val())) {
                jVal.errors = true;
                emailInfo.removeClass('correct').addClass('error').show();
                $('.email_lab').addClass('wrong').html(ele.data('error'));
                ele.removeClass('normal').addClass('wrong');
            } else {
                emailInfo.removeClass('error').addClass('correct').html('').show();
                $('.email_lab').removeClass('wrong').html('').show();
                ele.removeClass('wrong').addClass('normal');
            }
            },



        'sendIt' : function (){

            if(!jVal.errors) {
                $('#account-register-form').submit();
            }
        }

    };

// ====================================================== //

    $('#send').click(function (){

      //  var obj = $.browser.webkit ? $('body') : $('html');
     /*   obj.animate({ scrollTop: $('#jform').offset().top }, 750, function (){ */

            jVal.errors = false;
            jVal.fullName();
            jVal.password();
            jVal.email();
            jVal.sendIt();

       /* }); */
        return false;
    });

    $('#fullname').change(jVal.fullName);
    $('#password').change(jVal.password);
    $('#email').change(jVal.email);


// ====================================================== //
});