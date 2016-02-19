funcUserApiYandexToken = {
    parse: function () {
        var hash = window.location.hash;
        if (hash != '') {
            var params = hash.substr(1).split('&');

            for (var i in params) {
                var tmp = params[i].split('=');

                if (tmp[0] === 'access_token') {
                    $('.select-area-code').html(tmp[1]);
                    break;
                }
            }
        }

    },
    init: function () {
        this.parse();
    }
};

$(document).ready(function () {
    //init func
    funcUserApiYandexToken.init();
});