funcProfilePeople = {
    ban: {
        action: function () {
            $('.people-section-table .action-ban').off('click').on('click', function (e) {
                e.preventDefault();
                var id = ~~($(this).closest('.user-row').attr('data-id'));

                if (id > 0) {
                    $('#banUserModal').modal('show').find('input.user-ban-id').val(id);
                }
            });
        },
        modal: function () {
            $('#banUserModal .modal-footer .user-ban').on('click', function (e) {
                e.preventDefault();
                var modal = $(this).closest('#banUserModal');
                var url = modal.find('input.user-ban-id').data('url');
                var id = modal.find('input.user-ban-id').val();

                $.post(url, {id: id}, function (data) {
                    if (data.status === true) {
                        $('.people-section-table .user-row[data-id="' + id + '"]').remove();
                        modal.modal('hide');
                    } else {
                        funcDefault.error(modal.find('.modal-footer'), data.message);
                    }
                });
            });
        },
    },
    friend: {
        action: function () {
            $('.people-section-table .action-friend').off('click').on('click', function (e) {
                e.preventDefault();
                var id = ~~($(this).closest('.user-row').attr('data-id'));

                if (id > 0) {
                    var type = $(this).attr('data-type');
                    var title = $(this).attr('data-title');
                    var btn = $(this).attr('data-btn');
                    
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
                        var row = $('.people-section-table .user-row[data-id="' + id + '"]');

                        if (type == 'remove') {
                            row.remove();
                        } else {
                            row.find('.user-friend-header').html(data.header);
                            row.find('.user-friend-link').html(data.link);
                        }
                        
                        funcProfilePeople.friend.action();
                        modal.modal('hide');
                    } else {
                        funcDefault.error(modal.find('.modal-footer'), data.message);
                    }
                });
            });
        },
    },
    update: function () {
        if (typeof (funcProfileWidgetsMenuPeopleWidget.updateCallback) !== 'undefined') {
            funcProfileWidgetsMenuPeopleWidget.updateCallback =  
                'funcProfilePeople.ban.action(); '+
                'funcProfilePeople.friend.action(); '+
                'funcProfilePeople.scroll.status = false; '+
                'funcProfilePeople.scroll.page = 1; ';
        }
    },
    scroll: {
        status: false,
        page: 1,
        action: function () {
            var table = $('.people-section-table');

            $(window).scroll(function () {
                if (funcProfilePeople.scroll.status === false) {
                    if ($(document).height() - $(window).height() <= $(window).scrollTop() + 250) {
                        funcProfilePeople.scroll.status = true;
                        funcProfilePeople.scroll.loader(true);

                        var el = $('.people-nav-container #peoples-search');
                        var url = el.data('url');
                        var vals = {
                            'q': el.val(),
                            'page': funcProfilePeople.scroll.page
                        };

                        if (table.length > 0) {
                            $.post(url, vals, function (data) {
                                if (data.status === true) {
                                    table.append(data.users);

                                    funcProfilePeople.ban.action();
                                    funcProfilePeople.friend.action();
                                    funcProfilePeople.scroll.status = false;
                                    funcProfilePeople.scroll.page++;
                                }
                                
                                funcProfilePeople.scroll.loader(false);
                            });
                        }
                    }
                }
            });
        },
        loader: function (status) {
            if (status === true) {
                $('.people-section-loader').removeClass('hidden');
            } else {
                $('.people-section-loader').addClass('hidden');
            }
        }
    },
    init: function () {
        this.ban.action();
        this.ban.modal();
        this.update();
        this.friend.action();
        this.friend.modal();
        this.scroll.action();
    }
};

$(document).ready(function () {
    //init func
    funcProfilePeople.init();
});