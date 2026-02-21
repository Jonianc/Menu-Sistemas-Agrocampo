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


    function getFieldValue(name) {
        const field = form.find(`[name="${menuSistemasAgrocampo.optionKey}[${name}]"]`);
        return String(field.val() || '').trim();
    }

    function getSelectedLinkTarget() {
        const linkTarget = getFieldValue('link_target');
        return linkTarget === '_self' ? '_self' : '_blank';
    }

    function getPreviewItems() {
        const items = [];

        itemsContainer.find('.msa-item-block').each(function () {
            const block = $(this);
            const title = String(block.find('input[name*="[title]"]').first().val() || '').trim();
            const description = String(block.find('input[name*="[description]"]').first().val() || '').trim();
            const badge = String(block.find('input[name*="[badge]"]').first().val() || '').trim();
            const hidden = block.find('input[name*="[hidden]"]').first().is(':checked');
            const links = [];

            block.find('.msa-link-row').each(function () {
                const row = $(this);
                const label = String(row.find('input[name*="[label]"]').val() || '').trim();
                const url = String(row.find('input[name*="[url]"]').val() || '').trim();

                if (label !== '' && url !== '') {
                    links.push({ label, url });
                }
            });

            if (!hidden) {
                items.push({ title, description, badge, links });
            }
        });

        return items;
    }

    function renderPreview() {
        const title = getFieldValue('title') || 'Menú Sistemas Agrocampo';
        const subtitle = getFieldValue('subtitle') || 'Acceso rápido a los sistemas de gestión.';
        const logoUrl = getFieldValue('logo_url');
        const quickAccessLabel = getFieldValue('quick_access_label');
        const quickAccessUrl = getFieldValue('quick_access_url');
        const headerLayout = getFieldValue('header_layout') || 'center';
        const linkTarget = getSelectedLinkTarget();
        const previewItems = getPreviewItems();

        const previewHeader = $('#msa-preview-header');
        previewHeader
            .removeClass('msa-admin-preview__header--center msa-admin-preview__header--logo-right msa-admin-preview__header--logo-left')
            .addClass(`msa-admin-preview__header--${headerLayout}`);

        $('#msa-preview-title').text(title);
        $('#msa-preview-subtitle').text(subtitle);

        const previewLogo = $('#msa-preview-logo');
        if (logoUrl !== '') {
            previewLogo.attr('src', logoUrl).prop('hidden', false);
        } else {
            previewLogo.attr('src', '').prop('hidden', true);
        }

        const quickLink = $('#msa-preview-quick-link');
        if (quickAccessLabel !== '' && quickAccessUrl !== '') {
            quickLink
                .text(quickAccessLabel)
                .attr('href', quickAccessUrl)
                .attr('target', linkTarget)
                .prop('hidden', false);

            if (linkTarget === '_blank') {
                quickLink.attr('rel', 'noopener noreferrer');
            } else {
                quickLink.removeAttr('rel');
            }
        } else {
            quickLink.text('').attr('href', '#').prop('hidden', true);
        }

        const grid = $('#msa-preview-grid');
        grid.empty();

        if (previewItems.length === 0) {
            grid.append(
                $('<article>', { class: 'msa-admin-preview__card msa-admin-preview__card--empty' })
                    .append($('<h4>', { class: 'msa-admin-preview__card-title', text: menuSistemasAgrocampo.labels.previewNoItems }))
            );
            return;
        }

        previewItems.forEach(function (item) {
            const card = $('<article>', { class: 'msa-admin-preview__card' });
            const heading = $('<div>', { class: 'msa-admin-preview__card-heading' });
            heading.append($('<h4>', { class: 'msa-admin-preview__card-title', text: item.title || menuSistemasAgrocampo.labels.previewUntitled }));

            if (item.badge !== '') {
                heading.append($('<span>', { class: 'msa-admin-preview__badge', text: item.badge }));
            }

            card.append(heading);
            card.append($('<p>', { class: 'msa-admin-preview__card-description', text: item.description || menuSistemasAgrocampo.labels.previewNoDescription }));

            if (item.links.length > 0) {
                const actions = $('<div>', { class: 'msa-admin-preview__actions' });
                item.links.forEach(function (link) {
                    const anchor = $('<a>', {
                        class: 'msa-admin-preview__link',
                        href: link.url,
                        target: linkTarget,
                        text: link.label
                    });

                    if (linkTarget === '_blank') {
                        anchor.attr('rel', 'noopener noreferrer');
                    }

                    actions.append(anchor);
                });
                card.append(actions);
            }

            grid.append(card);
        });
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
            renderPreview();
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
        renderPreview();
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
        renderPreview();
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
        renderPreview();
    });

    $(document).on('click', '.msa-remove-link', function (event) {
        event.preventDefault();

        if (!guardNonceContext()) {
            return;
        }

        $(this).closest('tr').remove();
        renderPreview();
    });

    $(document).on('input change', '.wrap form[action="options.php"] input, .wrap form[action="options.php"] select, .wrap form[action="options.php"] textarea', function () {
        renderPreview();
    });

    form.on('submit', function () {
        reindexItems();
    });

    $(function () {
        initSortable();
        reindexItems();
        bindUrlValidation($(document));
        toggleEmptyState();
        renderPreview();
    });
})(jQuery);
