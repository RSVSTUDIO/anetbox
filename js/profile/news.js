funcProfileNews = {
    submit: function () {
        $('#addNewsModal .add-news').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.modal-content').find('.ajax-submit-button').trigger('click');
            funcDefault.loader(true);
        });
    },
    show: function () {
        $('.news-section-table .action-read-more').off('click').on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');

            funcDefault.loader(true);

            $.get(url, null, function (data) {
                if (data.status === true) {
                    var modal = $('#showNewsModal');
                    modal.find('.modal-title').html(data.title);
                    modal.find('.full-text').html(data.text);
                    modal.find('.url-text').html(data.url);
                    modal.modal('show');
                }

                funcDefault.loader(false);
            }, 'json');

        });
    },
    add: {
        action: function () {
            $('.list-group-item.btn[data-target="#addNewsModal"]').on('click', function (e) {
                e.preventDefault();
                
                var textLabel = $(this).attr('data-text-label');
                var textBtn = $(this).attr('data-text-btn');
                var data = {
                    id: 0,
                    instrument_id: 1,
                    title: '',
                    short_text: '',
                    full_text: '',
                    url: ''
                };
                
                funcProfileNews.set(data);
                
                $('#addNewsModal #addNewsModalLabel').html(textLabel);
                $('#addNewsModal .btn.add-news').html(textBtn);
            });
        },
    },
    edit: {
        action: function () {
            $('.news-section-table .action-edit').off('click').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                var textLabel = $(this).attr('data-text-label');
                var textBtn = $(this).attr('data-text-btn');

                funcDefault.loader(true);

                $.get(url, null, function (data) {
                    if (data.status === true) {
                        funcProfileNews.set(data);
                        
                        $('#addNewsModal #addNewsModalLabel').html(textLabel);
                        $('#addNewsModal .btn.add-news').html(textBtn);
                        
                        $('#addNewsModal').modal('show');
                    }

                    funcDefault.loader(false);
                }, 'json');

            });
        }
    },
    remove: {
        action: function () {
            $('.news-section-table .action-delete').off('click').on('click', function (e) {
                e.preventDefault();
                var id = ~~($(this).closest('.news-row').attr('data-id'));

                if (id > 0) {
                    $('#delNewsModal').modal('show').find('input.news-id').val(id);
                }
            });
        },
        modal: function () {
            $('#delNewsModal .modal-footer .news-delete').on('click', function (e) {
                e.preventDefault();
                var modal = $(this).closest('#delNewsModal');
                var url = modal.find('input.news-id').data('url');
                var id = modal.find('input.news-id').val();

                $.post(url, {id: id}, function (data) {
                    if (data.status === true) {
                        modal.modal('hide');
                        $('.news-section-table .news-row[data-id="' + id + '"]').remove();
                    } else {
                        funcDefault.error(modal.find('.modal-footer'), data.message);
                    }
                });
            });
        }
    },
    reload: function () {
        funcProfileNews.show();
        funcProfileNews.edit.action();
        funcProfileNews.remove.action();
    },
    set: function (data) {
        var modal = $('#addNewsModal');
        modal.find('#news-id').val(data.id);
        modal.find('#news-instrument-id').val(data.instrument_id);
        modal.find('#news-title').val(data.title);
        modal.find('#news-url').val(data.url);

        modal.find('#news-short-text')
            .val(data.short_text)
            .data('wysihtml5')
            .editor
            .setValue(data.short_text);

        modal.find('#news-full-text')
            .val(data.full_text)
            .data('wysihtml5')
            .editor
            .setValue(data.full_text);
    },
    redactor: function () {
        var options = {
            'font-styles': true, //Font styling, e.g. h1, h2, etc. Default true
            'emphasis': true, //Italics, bold, etc. Default true
            'lists': true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            'html': false, //Button which allows you to edit the generated HTML. Default false
            'link': true, //Button to insert a link. Default true
            'image': true, //Button to insert an image. Default true,
            'color': true, //Button to change color of font  
            
            'stylesheets': ['/css/bootstrap3-wysiwyg5-color.css'],
        };

        $('#addNewsModal #news-short-text').wysihtml5(options);
        $('#addNewsModal #news-full-text').wysihtml5(options);
    },
    scroll: {
        status: false,
        page: 1,
        action: function () {
            var table = $('.news-section-table');

            $(window).scroll(function () {
                if (funcProfileNews.scroll.status === false) {
                    if ($(document).height() - $(window).height() <= $(window).scrollTop() + 250) {
                        funcProfileNews.scroll.status = true;

                        if (table.find('.news-row').length > 0) {
                            funcProfileNews.scroll.loader(true);

                            var url = table.data('url');
                            var vals = {
                                'page': funcProfileNews.scroll.page
                            };

                            $.post(url, vals, function (data) {
                                if (data.status === true) {
                                    table.append(data.news);

                                    funcProfileNews.reload();
                                    funcProfileNews.scroll.status = false;
                                    funcProfileNews.scroll.page++;
                                }

                                funcProfileNews.scroll.loader(false);
                            });
                        }
                    }
                }
            });
        },
        loader: function (status) {
            if (status === true) {
                $('.news-section-loader').removeClass('hidden');
            } else {
                $('.news-section-loader').addClass('hidden');
            }
        }
    },
    init: function () {
        this.submit();
        this.reload();
        this.remove.modal();
        this.scroll.action();
        this.add.action();
        this.redactor();
    }
};

$(document).ready(function () {
    //init func
    funcProfileNews.init();
});