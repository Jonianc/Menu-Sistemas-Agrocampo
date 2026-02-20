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

    function validateUrlInput(input) {
        const value = input.val().trim();

        if (value === '' || input[0].checkValidity()) {
            input.removeClass('msa-url-invalid');
            input[0].setCustomValidity('');
            return;
        }

        input.addClass('msa-url-invalid');
        input[0].setCustomValidity('Por favor ingresa una URL válida (ej: https://dominio.com).');
    }

    function bindUrlValidation(scope) {
        scope.find('input[type="url"]').each(function () {
            const input = $(this);
            validateUrlInput(input);
        });
    }

    function toggleEmptyState() {
        const hasItems = $('#msa-items .msa-item-block').length > 0;
        $('.msa-empty-state').toggle(!hasItems);
    }

    function reindexItems() {
        $('#msa-items .msa-item-block').each(function (newIndex) {
            const itemBlock = $(this);
            const previousIndex = parseInt(itemBlock.data('item-index'), 10);

            if (Number.isNaN(previousIndex) || previousIndex === newIndex) {
                itemBlock.attr('data-item-index', newIndex);
                itemBlock.data('item-index', newIndex);
                return;
            }

            itemBlock.attr('data-item-index', newIndex);
            itemBlock.data('item-index', newIndex);

            itemBlock.find('input, select, textarea').each(function () {
                const field = $(this);
                const name = field.attr('name');
                if (!name) {
                    return;
                }

                field.attr(
                    'name',
                    name.replace(/\[items\]\[\d+\]/, `[items][${newIndex}]`)
                );
            });
        });
    }

    function initSortable() {
        const list = $('#msa-items');
        if (!$.fn.sortable || !list.length) {
            return;
        }

        list.sortable({
            items: '.msa-item-block',
            handle: '.msa-drag-item',
            placeholder: 'msa-sort-placeholder',
            forcePlaceholderSize: true,
            update: function () {
                reindexItems();
            }
        });
    }

    $(document).on('input blur', 'input[type="url"]', function () {
        validateUrlInput($(this));
    });

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
        const newItem = $(html);
        $('#msa-items').append(newItem);
        bindUrlValidation(newItem);
        reindexItems();
        toggleEmptyState();
    });

    $(document).on('click', '.msa-remove-item', function (event) {
        event.preventDefault();

        if (!window.confirm(menuSistemasAgrocampo.labels.removeSystemConfirm)) {
            return;
        }

        $(this).closest('.msa-item-block').remove();
        reindexItems();
        toggleEmptyState();
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
        const newRow = $(row);
        $(this).closest('table').find('tbody').append(newRow);
        bindUrlValidation(newRow);
    });

    $(document).on('click', '.msa-remove-link', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });

    $('form').on('submit', function () {
        reindexItems();
    });

    $(function () {
        initSortable();
        reindexItems();
        bindUrlValidation($(document));
        toggleEmptyState();
    });
})(jQuery);
