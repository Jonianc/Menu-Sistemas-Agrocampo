(function ($) {
    $(document).on('click', '.msa-upload-logo', function (event) {
        event.preventDefault();
        const button = $(this);
        const input = $('#msa-logo-url');
        const frame = wp.media({
            title: 'Selecciona un logo',
            button: { text: 'Usar este logo' },
            multiple: false
        });

        frame.on('select', function () {
            const attachment = frame.state().get('selection').first().toJSON();
            input.val(attachment.url);
        });

        frame.open();
    });
})(jQuery);
