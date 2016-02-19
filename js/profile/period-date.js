funcProfilePeriodDate = {
    load: function () {
        $('.period-datetime-field').datetimepicker({
            pickDate: true,
            pickTime: false,
            useMinutes: false,
            useSeconds: false,
            showToday: true,
            language: localeId.replace("\_", "\-"),
            use24hours: true,
            sideBySide: false,
            format: 'YYYY-MM-DD'
        });
    },
    submit: function () {
        $('.form-set-period-date').on('submit', function (e) {
            e.preventDefault();
        });

        $('.period-datetime-field').on('change', function () {
            var el = $(this);
            var form = el.closest('.form-set-period-date');
            var name = el.attr('name');
            var from = form.find('.period-datetime-field[name="date-from"]');
            var to = form.find('.period-datetime-field[name="date-to"]');
            var renderSelector = form.find('input[name="render-selector"]').val();

            var update = true;

            if (name === 'date-from') {
                if (from.val() > to.val() && from.val() != '' && to.val() != '') {
                    update = false;
                    to.data('DateTimePicker').setDate(from.val());
                }
            } else {
                if (to.val() < from.val() && to.val() != '' && from.val() != '') {
                    update = false;
                    from.data('DateTimePicker').setDate(to.val());
                }
            }

            if (update === true && renderSelector) {
                var url = form.attr('action');
                var vals = {
                    from: from.val() + (from.val() !== '' ? ' 00:00:00' : ''),
                    to: to.val() + (to.val() !== '' ? ' 23:59:59' : '')
                };
                
                funcDefault.loader(true);

                $.post(url, vals, function (data) {
                    var table = $(renderSelector);
                    var html = '';
                    
                    if (data.status === true) {
                        var renderCallback = form.find('input[name="render-callback"]').val();
                        if (renderCallback) {
                            eval('html = ' + renderCallback + '(data.json);');
                        } else {
                            html = funcProfilePeriodDate.render(data.json);
                        }
                    }
                    
                    table.html(html);
                    
                    funcDefault.loader(false);
                });

            }
        });
    },
    render: function (json) {
        var html = '';

        for (var i in json) {
            html += '<tr>';
                if (typeof (json[i].url) !== 'undefined') {
                    html += '<td class="text-left">' + json[i].url + '</td>';
                }
                if (typeof (json[i].title) !== 'undefined') {
                    html += '<td class="text-left">' + json[i].title + '</td>';
                }
                
                if (typeof (json[i].pages) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].pages + '</td>';
                }
                if (typeof (json[i].users) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].users + '</td>';
                }
                if (typeof (json[i].views) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].views + '</td>';
                }
                if (typeof (json[i].clicks) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].clicks + '</td>';
                }
                if (typeof (json[i].actions) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].actions + '</td>';
                }
                if (typeof (json[i].referrals) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].referrals + '</td>';
                }
                if (typeof (json[i].earnings) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].earnings + '</td>';
                }
                if (typeof (json[i].total) !== 'undefined') {
                    html += '<td class="text-center">' + json[i].total + '</td>';
                }

            html += '</tr>';
        }

        return html;
    },
    init: function () {
        this.load();
        this.submit();
    }
};

$(document).ready(function () {
    //init func
    funcProfilePeriodDate.init();
});