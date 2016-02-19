funcDriversNetworkFileUpload = {
    submit: function () {
        $('.form-upload-driver-file').on('submit', function (e) {
            e.preventDefault();
        });

        $('.form-upload-driver-file #upload-driver-file').on('change', function (e) {
            e.preventDefault();

            var el = $(this);
            var file = el[0].files;
            var form = el.closest('.form-upload-driver-file');
            var CSRF = form.find('input[name="CSRF_TOKEN"]').val();

            if (file.length > 0) {
                funcDefault.loader(true);
                
                var fd = new FormData();
                fd.append('CSRF_TOKEN', CSRF);
                fd.append('file', file[0]);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: fd,
                    enctype: 'multipart/form-data',
                    processData: false, // tell jQuery not to process the data
                    contentType: false   // tell jQuery not to set contentType
                }).done(function (data) {
                    if (data.status === true) {
                        el.val('');
                    }
                    
                    funcDefault.loader(false);
                });
            }
        });
    },
    init: function () {
        this.submit();
    }
};

$(document).ready(function () {
    //init func
    funcDriversNetworkFileUpload.init();
});