(function ($) {
    const itemsContainer = $('#msa-items');
    const form = $('.wrap form[action="options.php"]');

    function hasValidNonceContext() {
        const scriptNonce = menuSistemasAgrocampo.adminNonce || '';
        const inputNonce = String($('input[name="msa_admin_nonce"]').val() || '');

        return scriptNonce !== '' && inputNonce !== '' && scriptNonce === inputNonce;
    }

    function guardNonceContext() {
        if (hasValidNonceContext()) {
            return true;
        }

        window.alert(menuSistemasAgrocampo.labels.nonceError);
        return false;
    }


    function getNextIndex() {
        let maxIndex = -1;
        itemsContainer.find('.msa-item-block').each(function () {
            const index = parseInt($(this).attr('data-item-index'), 10);
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
            validateUrlInput($(this));
        });
    }

    function toggleEmptyState() {
        const hasItems = itemsContainer.find('.msa-item-block').length > 0;
        itemsContainer.find('.msa-empty-state').toggle(!hasItems);
    }

    function reindexItems() {
        itemsContainer.find('.msa-item-block').each(function (newIndex) {
            const itemBlock = $(this);
            itemBlock.attr('data-item-index', newIndex).data('item-index', newIndex);

            itemBlock.find('input, select, textarea').each(function () {
                const field = $(this);
                const name = field.attr('name');
                if (!name) {
                    return;
                }

                field.attr('name', name.replace(/\[items\]\[\d+\]/, `[items][${newIndex}]`));
            });
        });
    }

    function refreshSortableState() {
        if (!$.fn.sortable || !itemsContainer.length || !itemsContainer.hasClass('ui-sortable')) {
            return;
        }

        itemsContainer.sortable('refresh');

        if (itemsContainer.find('.msa-item-block').length <= 1) {
            itemsContainer.sortable('disable');
        } else {
            itemsContainer.sortable('enable');
        }
    }

    function initSortable() {
        if (!$.fn.sortable || !itemsContainer.length) {
            return;
        }

        if (itemsContainer.hasClass('ui-sortable')) {
            itemsContainer.sortable('destroy');
        }

        itemsContainer.sortable({
            items: '> .msa-item-block',
            handle: '.msa-drag-item',
            axis: 'y',
            tolerance: 'pointer',
            placeholder: 'msa-sort-placeholder',
            forcePlaceholderSize: true,
            helper: 'clone',
            start: function (_event, ui) {
                ui.placeholder.height(ui.item.outerHeight());
            },
            update: function () {
                reindexItems();
            }
        });

        refreshSortableState();
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
        const newItem = $(template.replace(/{{index}}/g, index));
        itemsContainer.append(newItem);

        bindUrlValidation(newItem);
        reindexItems();
        toggleEmptyState();
        refreshSortableState();
    });

    $(document).on('click', '.msa-remove-item', function (event) {
        event.preventDefault();

        if (!guardNonceContext()) {
            return;
        }

        if (!window.confirm(menuSistemasAgrocampo.labels.removeSystemConfirm)) {
            return;
        }

        $(this).closest('.msa-item-block').remove();
        reindexItems();
        toggleEmptyState();
        refreshSortableState();
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

        if (!guardNonceContext()) {
            return;
        }

        $(this).closest('tr').remove();
    });

    form.on('submit', function () {
        reindexItems();
    });

    $(function () {
        initSortable();
        reindexItems();
        bindUrlValidation($(document));
        toggleEmptyState();
    });
})(jQuery);
