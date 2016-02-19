funcProfileWidgetsMenuNetworksWidget = {
    tabs: function () {
        $('.networks-nav-container .tabs-networks .tab-index').on('click', function (e) {
            e.preventDefault();
            var el = $(this);
            var li = el.closest('li');
            
            if(!li.hasClass('active')){
                li.siblings('.active').removeClass('active');
                li.addClass('active');
                
                li.closest('.panel').find('.list-group.show').removeClass('show');
                li.closest('.panel').find('.list-group.' + el.data('id')).addClass('show');
            }
        });
    },
    init: function () {
        this.tabs();
    }
};

$(document).ready(function () {
    //init func
    funcProfileWidgetsMenuNetworksWidget.init();
});