funcProfileAreas = {
    timeout: 0,
    select: function () {
        $('.areas-section-site .code-textarea').on('focus click', function (e) {
            e.preventDefault();
            $(this).select();
        });
    },
    confirm: function () {
        $('.areas-section-site .code-comfirm').on('click', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var vals = {
                'id': $(this).data('id')
            };

            funcDefault.loader(true);
            $.post(url, vals, function (data) {
                funcDefault.loader(false);
                if(data.status === true){
                    window.location.href = data.url;
                }
            });
        });
    },
    del: {
        site: function () {
            $('#delSiteModal .modal-footer .site-delete').on('click', function (e) {
                e.preventDefault();
                var modal = $(this).closest('#delSiteModal');
                var reload = modal.find('input.site-id').data('reload');
                var url = modal.find('input.site-id').data('url');
                var id = modal.find('input.site-id').val();
                
                $.post(url, {id: id}, function (data) {
                    if (data.status === true) {
                        modal.modal('hide');
                        window.location.href = reload;
                    } else {
                        funcDefault.error(modal.find('.modal-footer'), data.message);
                    }
                });
            });
        },
        network: function () {
            $('.areas-section-networks .action-delete').on('click', function (e) {
                e.preventDefault();
                var id = ~~($(this).attr('data-id'));

                if (id > 0) {
                    $('#delNetworkModal').modal('show').find('input.network-id').val(id);
                }
            });
            
            $('#delNetworkModal .modal-footer .network-delete').on('click', function (e) {
                e.preventDefault();
                var modal = $(this).closest('#delNetworkModal');
                var url = modal.find('input.network-id').data('url');
                var site = modal.find('input.network-id').data('site');
                var id = modal.find('input.network-id').val();

                $.post(url, {id: id, site: site}, function (data) {
                    if (data.status === true) {
                        modal.modal('hide');
                        window.location.href = data.url;
                    } else {
                        funcDefault.error(modal.find('.modal-footer'), data.message);
                    }
                });
            });
        }
    },
    submit: {
        addSite: function () {           
            $('#addSiteModal .add-site').on('click', function (event) {
                event.preventDefault();
                $(this).closest('.modal-content').find('.ajax-submit-button').trigger('click');
                funcDefault.loader(true);
            });
        },
        addNetwork: function () {
            $('.areas-section-networks .form-add-network .add-network').on('click', function (e) {
                e.preventDefault();
                $(this).closest('.form-add-network').find('.ajax-submit-button').trigger('click');
                funcDefault.loader(true);
            });
        },
        editNetwork: function () {
            $('.areas-section-networks .action-edit').on('click', function (e) {
                e.preventDefault();
                var id = ~~($(this).attr('data-id'));
                var network = $(this).attr('data-network');

                if (id > 0) {
                    $('#saveNetworkModal').find('input.save-network-id').val(id);
                    $('#saveNetworkModal').find('input#save-network-label').val(network);

                    $('#saveNetworkModal').find('input#save-network-login').val('');
                    $('#saveNetworkModal').find('input#save-network-password').val('');
                    
                    var form = $('#saveNetworkModal .form-save-network');
                    var url = $(this).data('url');
                    var vals = {
                        'id': id
                    };

                    funcDefault.loader(true);

                    $.post(url, vals, function (data) {

                        if (data.login === false) {
                            form.find('#save-network-login').closest('.form-group').addClass('hidden');
                        } else {
                            form.find('#save-network-login').closest('.form-group').removeClass('hidden');
                            form.find('#save-network-login').prev('label').html(data.login + ':');
                        }

                        if (data.password === false) {
                            form.find('#save-network-password').closest('.form-group').addClass('hidden');
                        } else {
                            form.find('#save-network-password').closest('.form-group').removeClass('hidden');
                            form.find('#save-network-password').prev('label').html(data.password + ':');
                        }

                        form.find('.helpNetworkBox').html(data.url);

                        funcDefault.loader(false);
                        $('#saveNetworkModal').modal('show');
                    });
                    
                }
            });
            
            $('#saveNetworkModal .modal-footer .save-network').on('click', function (e) {
                e.preventDefault();
                $(this).closest('#saveNetworkModal').find('.ajax-submit-button').trigger('click');
                funcDefault.loader(true);
            });
        },
        selectNetwork: function () {
            $('.areas-section-networks .form-add-network #network_instrument_id').on('change', function () {
                var form = $('.areas-section-networks .form-add-network');
                var url = $(this).data('url');
                var vals = {
                    'id': $(this).val()
                };
                
                funcDefault.loader(true);

                $.post(url, vals, function (data) {
                    
                    if (data.login === false) {
                        form.find('#network-login').closest('.form-group').addClass('hidden');
                    } else {
                        form.find('#network-login').closest('.form-group').removeClass('hidden');
                        form.find('.labelNetworkLogin').html(data.login);
                        form.find('#network-login').attr('placeholder', data.login);
                    }

                    if (data.password === false) {
                        form.find('#network-password').closest('.form-group').addClass('hidden');
                    } else {
                        form.find('#network-password').closest('.form-group').removeClass('hidden');
                        form.find('.labelNetworkPassword').html(data.password);
                        form.find('#network-password').attr('placeholder', data.password);
                    }
                    
                    form.find('.helpNetworkBox').html(data.url);
                    
                    funcDefault.loader(false);
                });
            });
        }
    },
    render: {
        companyAreas: function (json) {
            var html = '';

            for (var i in json) {
                html += '<tr>' +
                            '<td class="col-md-2 text-left disable-element">баннер</td>' +
                            '<td class="text-left">' + json[i].title + '</td>' +
                            '<td class="text-center">' + json[i].ctr + '%</td>' +
                            '<td class="text-center disable-element">получить</td>' +
                            '<td class="text-center">' + json[i].earnings + '</td>' +
                        '</tr>';
            }

            return html;
        }
    },
    init: function () {
        this.select();
        this.confirm();
        this.del.site();
        this.del.network();
        this.submit.addSite();
        this.submit.addNetwork();
        this.submit.editNetwork();
        this.submit.selectNetwork();
    }
};

$(document).ready(function () {
    //init func
    funcProfileAreas.init();
});