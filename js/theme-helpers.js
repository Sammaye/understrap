jQuery(function() {
    autosize(jQuery('textarea.autosize'));
});

jQuery(document).on('submit', '.ajax-form', function (e) {
    e.preventDefault();
    var form = jQuery(this).serializeArray(),
        el = jQuery(this);

    form[form.length] = {name: 'action', value: jQuery(this).attr('action')};

    return jQuery.post(
        params.ajaxurl,
        form,
        null,
        'json'
    ).done(function (data) {
        el.trigger('form.done', data);

        var alert = el.find('.alert');

        if (data.success) {
            alert.empty().append(jQuery('<p/>').html(data.message));
            flashSuccess(alert, '', true);
        } else {
            ul = '';
            if (data.errors && data.errors.length > 0) {
                ul = jQuery('<ul/>');
                jQuery.each(data.errors, function (k, v) {
                    ul
                        .append(
                            jQuery('<li/>').html(v)
                        );
                });
            }

            alert.empty().append(
                jQuery('<p/>').html(data.message)
            ).append(ul);

            flashDanger(alert, '', true);
        }

        el.trigger('form.complete', [data, alert]);
    });
});

function flash(alert_el, type, message, dismissable) {
    alert_el.removeClass(function (index, className) {
        return (className.match(/(^|\s)alert-\S+/g) || []).join(' ');
    });
    alert_el.addClass('alert-' + type);

    if (message) {
        alert_el.html(message);
    }

    if (dismissable) {
        alert_el.addClass('alert-dismissable').prepend(
            jQuery('<button type="button" class="close" data-dismiss="alert" aria-label="Close"/>')
                .append(jQuery('<span aria-hidden="true"/>').html('&times;'))
        );
        alert_el.alert();
        alert_el.on('close.bs.alert', function (e) {
            jQuery(this).after(jQuery('<div class="alert fade show d-none" role="alert"/>'));
        });
    }

    alert_el
        .removeClass('d-none')
        .show(); // Not really needed but fuck it
}

function flashDanger(alert, message, dismissable) {
    return flash(alert, 'danger', message, dismissable);
}

function flashWarning(alert, message, dismissable) {
    return flash(alert, 'warning', message, dismissable);
}

function flashInfo(alert, message, dismissable) {
    return flash(alert, 'info', message, dismissable);
}

function flashSuccess(alert, message, dismissable) {
    return flash(alert, 'success', message, dismissable);
}

