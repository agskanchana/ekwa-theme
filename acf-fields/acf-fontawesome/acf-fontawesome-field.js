(function($) {
    'use strict';

    // Popular FontAwesome icons list
    var fontAwesomeIcons = [
        'house', 'home', 'user', 'users', 'gear', 'cog', 'envelope', 'phone', 'mobile',
        'location-dot', 'map-marker', 'star', 'heart', 'circle-check', 'check', 'xmark',
        'bars', 'magnifying-glass', 'search', 'cart-shopping', 'bag-shopping', 'calendar',
        'clock', 'bookmark', 'thumbs-up', 'thumbs-down', 'comment', 'comments', 'share',
        'download', 'upload', 'trash', 'edit', 'pen', 'plus', 'minus', 'circle-plus',
        'circle-minus', 'arrow-right', 'arrow-left', 'arrow-up', 'arrow-down', 'play',
        'pause', 'stop', 'forward', 'backward', 'circle-play', 'circle-pause', 'volume-high',
        'bell', 'file', 'folder', 'image', 'video', 'music', 'file-pdf', 'file-word',
        'print', 'floppy-disk', 'save', 'clipboard', 'link', 'lock', 'unlock', 'key',
        'eye', 'eye-slash', 'circle-info', 'info', 'triangle-exclamation', 'question',
        'circle-question', 'lightbulb', 'bolt', 'fire', 'snowflake', 'sun', 'moon', 'cloud',
        'umbrella', 'gift', 'trophy', 'medal', 'crown', 'flag', 'location-pin', 'graduation-cap',
        'book', 'newspaper', 'building', 'hospital', 'school', 'store', 'car', 'plane',
        'train', 'bus', 'bicycle', 'motorcycle', 'truck', 'ship', 'rocket', 'wifi', 'signal',
        'battery-full', 'plug', 'mobile-screen', 'laptop', 'desktop', 'tablet', 'keyboard',
        'camera', 'tv', 'headphones', 'microphone', 'database', 'server', 'code', 'terminal',
        'bug', 'shield', 'gauge', 'chart-line', 'chart-bar', 'chart-pie', 'wallet', 'credit-card',
        'money-bill', 'coins', 'percent', 'tag', 'tags', 'barcode', 'qrcode', 'ticket',
        'pizza-slice', 'burger', 'mug-hot', 'coffee', 'wine-glass', 'martini-glass', 'utensils',
        'basketball', 'football', 'baseball', 'volleyball', 'futbol', 'dumbbell', 'person-running',
        'person-walking', 'person-swimming', 'person-biking', 'gamepad', 'chess', 'dice',
        'puzzle-piece', 'brush', 'palette', 'paint-roller', 'scissors', 'wrench', 'hammer',
        'screwdriver', 'tree', 'leaf', 'seedling', 'clover', 'paw', 'dog', 'cat', 'fish',
        'horse', 'dragon', 'spider', 'hand', 'hand-pointer', 'hand-peace', 'handshake',
        'thumbtack', 'paperclip', 'at', 'hashtag', 'dollar-sign', 'euro-sign', 'pound-sign',
        'yen-sign', 'indian-rupee-sign', 'bitcoin-sign'
    ];

    // Brand icons
    var brandIcons = [
        'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok', 'pinterest',
        'snapchat', 'whatsapp', 'telegram', 'reddit', 'discord', 'twitch', 'github',
        'gitlab', 'stack-overflow', 'google', 'apple', 'microsoft', 'android', 'windows',
        'linux', 'amazon', 'shopify', 'wordpress', 'drupal', 'joomla', 'paypal', 'stripe',
        'spotify', 'soundcloud', 'vimeo', 'dribbble', 'behance', 'figma', 'sketch',
        'npm', 'yarn', 'docker', 'node-js', 'react', 'angular', 'vuejs', 'python', 'php',
        'java', 'slack', 'trello', 'dropbox', 'mailchimp'
    ];

    var allIcons = fontAwesomeIcons.concat(brandIcons);

    /**
     * Initialize FontAwesome picker
     */
    function initializeFontAwesomePicker($field) {
        var $picker = $field.find('.acf-fontawesome-picker');
        
        if ($picker.length === 0 || $picker.data('fa-initialized')) {
            return;
        }

        var fieldId = $picker.data('field-id');
        var $modal = $('#' + fieldId + '-modal');
        var $browseBtn = $picker.find('.acf-fa-browse-btn');
        var $clearBtn = $picker.find('.acf-fa-clear-btn');
        var $searchInput = $picker.find('.acf-fa-search');
        var $modalSearch = $modal.find('.acf-fa-modal-search');
        var $modalClose = $modal.find('.acf-fa-modal-close');
        var $modalOverlay = $modal.find('.acf-fa-modal-overlay');
        var $iconsGrid = $modal.find('.acf-fa-icons-grid');
        var $iconInput = $picker.find('.acf-fa-icon-input');
        var $styleInputs = $picker.find('input[type="radio"][name*="[style]"]');
        var $preview = $picker.find('.acf-fa-selected-preview i');
        var $selectedText = $picker.find('.acf-fa-selected-text');

        // Open modal
        $browseBtn.on('click', function(e) {
            e.preventDefault();
            openModal();
        });

        // Clear selection
        $clearBtn.on('click', function(e) {
            e.preventDefault();
            clearSelection();
        });

        // Close modal handlers
        $modalClose.on('click', closeModal);
        $modalOverlay.on('click', closeModal);

        // Search in main field
        $searchInput.on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            if (searchTerm) {
                var matches = allIcons.filter(function(icon) {
                    return icon.indexOf(searchTerm) !== -1;
                });
                if (matches.length > 0) {
                    renderIcons(matches.slice(0, 50));
                    openModal();
                }
            }
        });

        // Search in modal
        $modalSearch.on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            if (searchTerm) {
                var matches = allIcons.filter(function(icon) {
                    return icon.indexOf(searchTerm) !== -1;
                });
                renderIcons(matches);
            } else {
                renderIcons(allIcons);
            }
        });

        // Style change handler
        $styleInputs.on('change', function() {
            updatePreview();
        });

        function openModal() {
            $modal.show();
            renderIcons(allIcons);
            $modalSearch.val('').focus();
        }

        function closeModal() {
            $modal.hide();
        }

        function clearSelection() {
            $iconInput.val('');
            $searchInput.val('');
            $preview.attr('class', 'fa-regular fa-icons fa-2x').css('opacity', '0.3');
            $selectedText.html('<span style="opacity: 0.5;">No icon selected</span>');
            $clearBtn.hide();
        }

        function selectIcon(iconName) {
            $iconInput.val(iconName);
            $searchInput.val(iconName);
            updatePreview();
            closeModal();
            $clearBtn.show();
        }

        function updatePreview() {
            var iconName = $iconInput.val();
            if (!iconName) return;

            var selectedStyle = $styleInputs.filter(':checked').val() || 'regular';
            var iconClass = 'fa-' + selectedStyle + ' fa-' + iconName + ' fa-2x';
            
            $preview.attr('class', iconClass).css('opacity', '1');
            $selectedText.html('<strong>' + iconName + '</strong>');
        }

        function renderIcons(icons) {
            var $loading = $modal.find('.acf-fa-loading');
            $loading.show();
            $iconsGrid.empty();

            setTimeout(function() {
                if (icons.length === 0) {
                    $iconsGrid.html('<div class="acf-fa-no-results">No icons found</div>');
                    $loading.hide();
                    return;
                }

                var html = '';
                var selectedStyle = $styleInputs.filter(':checked').val() || 'solid';
                var isBrand = false;

                icons.forEach(function(icon) {
                    // Check if this is a brand icon
                    isBrand = brandIcons.indexOf(icon) !== -1;
                    var style = isBrand ? 'brands' : selectedStyle;
                    var iconClass = 'fa-' + style + ' fa-' + icon;
                    
                    html += '<div class="acf-fa-icon-item" data-icon="' + icon + '">';
                    html += '<i class="' + iconClass + '"></i>';
                    html += '<span>' + icon + '</span>';
                    html += '</div>';
                });

                $iconsGrid.html(html);
                $loading.hide();

                // Click handler for icon selection
                $iconsGrid.find('.acf-fa-icon-item').on('click', function() {
                    var iconName = $(this).data('icon');
                    selectIcon(iconName);
                });
            }, 100);
        }

        $picker.data('fa-initialized', true);
    }

    /**
     * ACF ready event
     */
    if (typeof acf !== 'undefined') {
        acf.addAction('ready', function($el) {
            $('.acf-field-fontawesome').each(function() {
                initializeFontAwesomePicker($(this));
            });
        });

        acf.addAction('append', function($el) {
            $el.find('.acf-field-fontawesome').each(function() {
                initializeFontAwesomePicker($(this));
            });
        });

        // For repeater fields
        acf.addAction('show_field', function(field) {
            if (field.$el && field.$el.hasClass('acf-field-fontawesome')) {
                initializeFontAwesomePicker(field.$el);
            }
        });
    }

})(jQuery);
