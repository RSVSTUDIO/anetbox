funcUserApi = {
    select: function () {
        $('.select-area-code').on('focus click', function (e) {
            e.preventDefault();
            funcDefault.select(this);
        });
    },
    init: function () {
        this.select();
    }
};

$(document).ready(function () {
    //init func
    funcUserApi.init();
});