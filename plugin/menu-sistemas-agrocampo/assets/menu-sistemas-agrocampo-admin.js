(function ($) {
    function getNextIndex() {
        let maxIndex = -1;
        $('#msa-items .msa-item-block').each(function () {
            const index = parseInt($(this).data('item-index'), 10);
            if (!Number.isNaN(index) && index > maxIndex) {
                maxIndex = index;
            }
        });
        return maxIndex + 1;
    }

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

    $(document).on('click', '#msa-add-item', function (event) {
        event.preventDefault();
        const template = $('#msa-item-template').html();
        const index = getNextIndex();
        const html = template.replace(/{{index}}/g, index);
        $('#msa-items').append(html);
    });
})(jQuery);
