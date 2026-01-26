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

    function getNextLinkIndex(itemBlock) {
        let maxIndex = -1;
        itemBlock.find('.msa-link-row').each(function () {
            const index = parseInt($(this).data('link-index'), 10);
            if (!Number.isNaN(index) && index > maxIndex) {
                maxIndex = index;
            }
        });
        return maxIndex + 1;
    }

    $(document).on('click', '.msa-upload-logo', function (event) {
        event.preventDefault();
        const input = $('#msa-logo-url');
        const frame = wp.media({
            title: menuSistemasAgrocampo.labels.selectLogo,
            button: { text: menuSistemasAgrocampo.labels.useLogo },
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

    $(document).on('click', '.msa-add-link', function (event) {
        event.preventDefault();
        const itemBlock = $(this).closest('.msa-item-block');
        const itemIndex = itemBlock.data('item-index');
        const linkIndex = getNextLinkIndex(itemBlock);
        const row = `
            <tr>
                <th scope="row"><label>${menuSistemasAgrocampo.labels.access} ${linkIndex + 1}</label></th>
                <td>
                    <div class="msa-link-row" data-link-index="${linkIndex}">
                        <input
                            type="text"
                            class="regular-text"
                            name="${menuSistemasAgrocampo.optionKey}[items][${itemIndex}][links][${linkIndex}][label]"
                            value=""
                            placeholder="${menuSistemasAgrocampo.labels.buttonName}"
                        >
                        <input
                            type="url"
                            class="regular-text"
                            name="${menuSistemasAgrocampo.optionKey}[items][${itemIndex}][links][${linkIndex}][url]"
                            value=""
                            placeholder="https://"
                        >
                        <button type="button" class="button msa-remove-link">${menuSistemasAgrocampo.labels.remove}</button>
                    </div>
                </td>
            </tr>
        `;
        $(this).closest('table').find('tbody').append(row);
    });

    $(document).on('click', '.msa-remove-link', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
})(jQuery);
