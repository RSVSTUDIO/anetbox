funcProfileNetworks = {
    submit: {
        register: function () {
            $('.network-section-info .form-add-network .add-network').on('click', function (event) {
                event.preventDefault();
                $(this).closest('.form-add-network').find('.ajax-submit-button').trigger('click');
                funcDefault.loader(true);
            });
        }
    },
    init: function () {
        this.submit.register();
    }
};

$(document).ready(function () {
    //init func
    funcProfileNetworks.init();
});