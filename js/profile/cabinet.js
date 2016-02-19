funcProfileCabinet = {
    scrollTop: function (id) {
        $('html,body').stop().animate({scrollTop: ($(id).offset().top - 80)}, 1000);
    },
    scroll: function () {
        $('.scroll-anchor').on('click', function (e) {
            e.preventDefault();

            var anchor = $(this).data('anchor');
            
            funcProfileCabinet.scrollTop(anchor);
        });
    },
    init: function () {
        this.scroll();
    }
};

$(document).ready(function () {
    //init func
    funcProfileCabinet.init();
});