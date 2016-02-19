funcProfileProfile = {
    add: {
        success: function (site) {
            $('.profile-section-areas .table tbody').append(
                '<tr class="area-row '+ (site.active === 'y' ? 'success' : 'warning') +'" data-id="'+ site.id +'">' +
                    '<td class="col-md-2">'+ site.title +'</td>' +
                    '<td class="col-md-2">'+ site.url +'</td>' +
                    '<td class="col-md-8">'+ site.description +'</td>' +
                    '<td><i class="fa fa-close action-delete"></i></td>' +
                '</tr>'
            );
        
            $('#addSiteModal .modal-body form')[0].reset();
            $('#addSiteModal').modal('hide');
            funcProfileProfile.del.action();
        },
        submit: function () {
            $('#addSiteModal .add-site').on('click', function (event) {
                event.preventDefault();
                $(this).closest('.modal-content').find('.ajax-submit-button').trigger('click');
                funcDefault.loader(true);
            });
        }
    },
    del: {
        action: function () {
            $('.profile-section-areas .action-delete').off('click').on('click', function (e) {
                e.preventDefault();
                var id = ~~($(this).closest('.area-row').attr('data-id'));

                if (id > 0) {
                    $('#delSiteModal').modal('show').find('input.site-id').val(id);
                }
            });
        },
        modal: function () {
            $('#delSiteModal .modal-footer .site-delete').on('click', function (e) {
                e.preventDefault();
                var modal = $(this).closest('#delSiteModal');
                var url = modal.find('input.site-id').data('url');
                var id = modal.find('input.site-id').val();

                $.post(url, {id: id}, function (data) {
                    if (data.status === true) {
                        $('.profile-section-areas .area-row[data-id="' + id + '"]').remove();
                        modal.modal('hide');
                    } else {
                        funcDefault.error(modal.find('.modal-footer'), data.message);
                    }
                });
            });
        }
    },
    friend: {
        action: function () {
            $('.profile-section-contact .action-friend').on('click', function (e) {
                e.preventDefault();
                var id = ~~($(this).closest('.user-row').attr('data-id'));

                if (id > 0) {
                    var type = $(this).data('type');
                    var title = $(this).data('title');
                    var btn = $(this).data('btn');
                    
                    var modal = $('#friendUserModal');
                    modal.find('.modal-header .modal-title').html(title);
                    modal.find('.modal-footer .btn.user-friend').html(btn);
                    modal.find('input.user-friend-id').val(id).attr('data-type', type);
                    modal.modal('show');
                }
            });
        },
        modal: function () {
            $('#friendUserModal .modal-footer .user-friend').on('click', function (e) {
                e.preventDefault();
                var modal = $(this).closest('#friendUserModal');
                var url = modal.find('input.user-friend-id').data('url');
                var id = modal.find('input.user-friend-id').val();
                var type = modal.find('input.user-friend-id').attr('data-type');

                $.post(url, {id: id, type: type}, function (data) {
                    if (data.status === true) {
                        var table = $('.profile-section-contact .incoming-requests');
                        $(table).find('.user-row[data-id="' + id + '"]').remove();
                        
                        if ($(table).find('.user-row').length === 0) {
                            table.closest('.panel-body').html(
                                '<p class="text-center">' + table.data('empty-text') + '</p>'
                            );
                        }
                        modal.modal('hide');
                    } else {
                        funcDefault.error(modal.find('.modal-footer'), data.message);
                    }
                });
            });
        },
    },
    init: function () {
        this.add.submit();
        this.del.action();
        this.del.modal();
        this.friend.action();
        this.friend.modal();
    }
};

$(document).ready(function () {
    //init func
    funcProfileProfile.init();
});