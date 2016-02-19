funcProfileWidgetsMenuPeopleWidget = {
    timeout: 0,
    updateCallback: null,
    search: function () {
        $('.people-nav-container #peoples-search').on('keyup', function () {
            var el = $(this);

            funcProfileWidgetsMenuPeopleWidget.timeout++;
            setTimeout(function () {
                funcProfileWidgetsMenuPeopleWidget.timeout--;
                if (funcProfileWidgetsMenuPeopleWidget.timeout === 0) {
                    var table = $('.people-section-table');
                    var url = el.data('url');
                    var vals = {
                        'q': el.val()
                    };
 
                    if(table.length > 0){
                        $.post(url, vals, function (data) {
                            table.html('');

                            if (data.status === true) {
                                table.html(data.users);
                                
                                if (funcProfileWidgetsMenuPeopleWidget.updateCallback !== null) {
                                    eval(funcProfileWidgetsMenuPeopleWidget.updateCallback);
                                }
                            }
                        });
                    }
                        
                }
            }, 500);
        });
    },
    init: function () {
        this.search();
    }
};

$(document).ready(function () {
    //init func
    funcProfileWidgetsMenuPeopleWidget.init();
});