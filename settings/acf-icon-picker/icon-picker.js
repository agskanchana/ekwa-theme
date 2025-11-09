(function($) {
    'use strict';

    // Font Awesome CDN base URL for SVG downloads
    const FA_CDN_BASE = 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/svgs/';

    // Helper function to fetch SVG from Font Awesome CDN
    function fetchFontAwesomeSVG(iconClass) {
        return new Promise((resolve, reject) => {
            // Parse icon class (e.g., "fa-solid fa-star")
            const parts = iconClass.split(' ');
            if (parts.length < 2) {
                reject('Invalid icon class');
                return;
            }

            let style = '';
            if (parts[0] === 'fa-solid') style = 'solid';
            else if (parts[0] === 'fa-regular') style = 'regular';
            else if (parts[0] === 'fa-brands') style = 'brands';
            else {
                reject('Unknown icon style');
                return;
            }

            const iconName = parts[1].replace('fa-', '');
            const svgUrl = `${FA_CDN_BASE}${style}/${iconName}.svg`;

            // Fetch SVG from CDN
            $.ajax({
                url: svgUrl,
                method: 'GET',
                dataType: 'text',
                success: function(svgCode) {
                    // Add viewBox if not present and clean up
                    let cleanSvg = svgCode.trim();
                    if (!cleanSvg.includes('viewBox')) {
                        cleanSvg = cleanSvg.replace('<svg', '<svg viewBox="0 0 512 512"');
                    }
                    resolve(cleanSvg);
                },
                error: function() {
                    reject('Failed to fetch SVG');
                }
            });
        });
    }

    // Popular Font Awesome icons database
    const popularIcons = {
        solid: [
            'fa-solid fa-house', 'fa-solid fa-user', 'fa-solid fa-phone', 'fa-solid fa-envelope',
            'fa-solid fa-location-dot', 'fa-solid fa-calendar', 'fa-solid fa-clock', 'fa-solid fa-star',
            'fa-solid fa-heart', 'fa-solid fa-thumbs-up', 'fa-solid fa-check', 'fa-solid fa-xmark',
            'fa-solid fa-plus', 'fa-solid fa-minus', 'fa-solid fa-magnifying-glass', 'fa-solid fa-bars',
            'fa-solid fa-cart-shopping', 'fa-solid fa-bag-shopping', 'fa-solid fa-credit-card', 'fa-solid fa-money-bill',
            'fa-solid fa-hospital', 'fa-solid fa-tooth', 'fa-solid fa-user-doctor', 'fa-solid fa-stethoscope',
            'fa-solid fa-pills', 'fa-solid fa-syringe', 'fa-solid fa-bed', 'fa-solid fa-wheelchair',
            'fa-solid fa-shield-halved', 'fa-solid fa-award', 'fa-solid fa-certificate', 'fa-solid fa-graduation-cap',
            'fa-solid fa-book', 'fa-solid fa-pen', 'fa-solid fa-paperclip', 'fa-solid fa-file',
            'fa-solid fa-folder', 'fa-solid fa-download', 'fa-solid fa-upload', 'fa-solid fa-share',
            'fa-solid fa-link', 'fa-solid fa-camera', 'fa-solid fa-image', 'fa-solid fa-video',
            'fa-solid fa-play', 'fa-solid fa-pause', 'fa-solid fa-stop', 'fa-solid fa-forward',
            'fa-solid fa-backward', 'fa-solid fa-volume-high', 'fa-solid fa-volume-xmark', 'fa-solid fa-music',
            'fa-solid fa-wifi', 'fa-solid fa-bluetooth', 'fa-solid fa-battery-full', 'fa-solid fa-plug',
            'fa-solid fa-lightbulb', 'fa-solid fa-fire', 'fa-solid fa-snowflake', 'fa-solid fa-sun',
            'fa-solid fa-moon', 'fa-solid fa-cloud', 'fa-solid fa-umbrella', 'fa-solid fa-tree',
            'fa-solid fa-leaf', 'fa-solid fa-seedling', 'fa-solid fa-paw', 'fa-solid fa-dog',
            'fa-solid fa-cat', 'fa-solid fa-fish', 'fa-solid fa-car', 'fa-solid fa-truck',
            'fa-solid fa-plane', 'fa-solid fa-helicopter', 'fa-solid fa-rocket', 'fa-solid fa-ship',
            'fa-solid fa-bicycle', 'fa-solid fa-motorcycle', 'fa-solid fa-bus', 'fa-solid fa-train',
            'fa-solid fa-building', 'fa-solid fa-house', 'fa-solid fa-store', 'fa-solid fa-warehouse',
            'fa-solid fa-utensils', 'fa-solid fa-mug-hot', 'fa-solid fa-pizza-slice', 'fa-solid fa-burger',
            'fa-solid fa-cake-candles', 'fa-solid fa-ice-cream', 'fa-solid fa-apple-whole', 'fa-solid fa-carrot',
            'fa-solid fa-dumbbell', 'fa-solid fa-baseball', 'fa-solid fa-basketball', 'fa-solid fa-football',
            'fa-solid fa-trophy', 'fa-solid fa-medal', 'fa-solid fa-crown', 'fa-solid fa-gift',
            'fa-solid fa-bell', 'fa-solid fa-comment', 'fa-solid fa-message', 'fa-solid fa-comments',
            'fa-solid fa-inbox', 'fa-solid fa-paper-plane', 'fa-solid fa-bookmark', 'fa-solid fa-flag',
            'fa-solid fa-map', 'fa-solid fa-compass', 'fa-solid fa-globe', 'fa-solid fa-earth-americas'
        ],
        regular: [
            'fa-regular fa-heart', 'fa-regular fa-star', 'fa-regular fa-user', 'fa-regular fa-envelope',
            'fa-regular fa-comments', 'fa-regular fa-comment', 'fa-regular fa-calendar', 'fa-regular fa-clock',
            'fa-regular fa-file', 'fa-regular fa-folder', 'fa-regular fa-bookmark', 'fa-regular fa-flag',
            'fa-regular fa-bell', 'fa-regular fa-thumbs-up', 'fa-regular fa-thumbs-down', 'fa-regular fa-circle-check',
            'fa-regular fa-circle-xmark', 'fa-regular fa-circle-question', 'fa-regular fa-circle-play', 'fa-regular fa-circle-pause',
            'fa-regular fa-square', 'fa-regular fa-circle', 'fa-regular fa-image', 'fa-regular fa-images',
            'fa-regular fa-sun', 'fa-regular fa-moon', 'fa-regular fa-eye', 'fa-regular fa-eye-slash',
            'fa-regular fa-hand', 'fa-regular fa-handshake', 'fa-regular fa-face-smile', 'fa-regular fa-face-frown'
        ],
        brands: [
            'fa-brands fa-facebook', 'fa-brands fa-twitter', 'fa-brands fa-instagram', 'fa-brands fa-linkedin',
            'fa-brands fa-youtube', 'fa-brands fa-tiktok', 'fa-brands fa-pinterest', 'fa-brands fa-snapchat',
            'fa-brands fa-whatsapp', 'fa-brands fa-telegram', 'fa-brands fa-discord', 'fa-brands fa-slack',
            'fa-brands fa-google', 'fa-brands fa-apple', 'fa-brands fa-microsoft', 'fa-brands fa-amazon',
            'fa-brands fa-paypal', 'fa-brands fa-stripe', 'fa-brands fa-shopify', 'fa-brands fa-wordpress',
            'fa-brands fa-github', 'fa-brands fa-gitlab', 'fa-brands fa-bitbucket', 'fa-brands fa-stack-overflow',
            'fa-brands fa-reddit', 'fa-brands fa-medium', 'fa-brands fa-dev', 'fa-brands fa-codepen',
            'fa-brands fa-dribbble', 'fa-brands fa-behance', 'fa-brands fa-figma', 'fa-brands fa-sketch',
            'fa-brands fa-android', 'fa-brands fa-app-store', 'fa-brands fa-chrome', 'fa-brands fa-firefox',
            'fa-brands fa-edge', 'fa-brands fa-safari', 'fa-brands fa-opera', 'fa-brands fa-brave'
        ]
    };

    // Global variable to track which field is currently using the modal
    let currentField = null;

    // Initialize icon picker
    function initIconPicker() {
        // Use single modal for all pickers
        let $modal = $('.ekwa-icon-modal').first();
        if (!$modal.length) {
            $('body').append(`
                <div class="ekwa-icon-modal" style="display: none;">
                    <div class="ekwa-icon-modal-content">
                        <div class="ekwa-icon-modal-header">
                            <input type="text" class="ekwa-icon-search" placeholder="Search icons (e.g., home, user, phone)..." />
                            <button type="button" class="ekwa-modal-close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="ekwa-icon-categories">
                            <button type="button" class="ekwa-cat-btn active" data-category="all">All</button>
                            <button type="button" class="ekwa-cat-btn" data-category="solid">Solid</button>
                            <button type="button" class="ekwa-cat-btn" data-category="regular">Regular</button>
                            <button type="button" class="ekwa-cat-btn" data-category="brands">Brands</button>
                        </div>
                        <div class="ekwa-icon-grid">
                            <div class="ekwa-loading"><i class="fas fa-spinner fa-spin"></i> Loading icons...</div>
                        </div>
                    </div>
                </div>
            `);
            $modal = $('.ekwa-icon-modal').first();
        }

        const $grid = $modal.find('.ekwa-icon-grid');
        const $search = $modal.find('.ekwa-icon-search');

        $('.ekwa-icon-picker-wrap').each(function() {
            const $wrap = $(this);

            // Skip if already initialized
            if ($wrap.data('picker-init')) {
                return;
            }
            $wrap.data('picker-init', true);

            const $typeInput = $wrap.find('.ekwa-icon-type');
            const $valueInput = $wrap.find('.ekwa-icon-value');
            const $preview = $wrap.find('.ekwa-icon-preview');
            const $svgInput = $wrap.find('.ekwa-svg-input');

            // Open modal
            $wrap.on('click', '.ekwa-open-picker', function(e) {
                e.preventDefault();
                currentField = $wrap;
                console.log('Opening modal, currentField set:', currentField.length);
                $modal.fadeIn(200);
                loadIcons($grid, 'all');
                $search.val('').focus();
            });

            // SVG input - update preview and hidden field
            $wrap.on('input', '.ekwa-svg-input', function() {
                const svgCode = $(this).val().trim();
                $valueInput.val(svgCode).trigger('change');
                $typeInput.val('svg');

                if (svgCode && svgCode.includes('<svg')) {
                    $preview.html(`
                        <div class="ekwa-icon-svg-preview">${svgCode}</div>
                        <span class="ekwa-icon-class">Custom SVG</span>
                    `);
                } else {
                    $preview.html(`
                        <i class="fas fa-icons"></i>
                        <span class="ekwa-icon-class">No icon selected</span>
                    `);
                }
            });
        });

        // Close modal (single handler for shared modal)
        $modal.off('click').on('click', function(e) {
            // Only close if clicking the overlay (not modal content) or close button
            if ($(e.target).hasClass('ekwa-icon-modal') ||
                $(e.target).hasClass('ekwa-modal-close') ||
                $(e.target).closest('.ekwa-modal-close').length) {
                console.log('Closing modal via overlay/close button');
                $modal.fadeOut(200);
                currentField = null;
            }
        });

        // ESC key to close modal
        $(document).off('keydown.ekwa-modal').on('keydown.ekwa-modal', function(e) {
            if (e.keyCode === 27 && $modal.is(':visible')) {
                $modal.fadeOut(200);
                currentField = null;
            }
        });

        // Category filter (single handler for shared modal)
        $modal.off('click', '.ekwa-cat-btn').on('click', '.ekwa-cat-btn', function() {
            const category = $(this).data('category');
            $modal.find('.ekwa-cat-btn').removeClass('active');
            $(this).addClass('active');
            loadIcons($grid, category, $search.val());
        });

        // Search (single handler for shared modal)
        let searchTimeout;
        $search.off('input').on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val().toLowerCase();
            const category = $modal.find('.ekwa-cat-btn.active').data('category');

            searchTimeout = setTimeout(() => {
                loadIcons($grid, category, query);
            }, 300);
        });

        // Select icon (single handler for shared modal)
        $grid.off('click', '.ekwa-icon-item').on('click', '.ekwa-icon-item', function() {
            console.log('Icon clicked, currentField:', currentField ? currentField.length : 'null');
            if (!currentField) {
                console.error('currentField is null!');
                return;
            }

            const $item = $(this);
            const iconClass = $item.data('icon');
            const $valueInput = currentField.find('.ekwa-icon-value');
            const $typeInput = currentField.find('.ekwa-icon-type');
            const $preview = currentField.find('.ekwa-icon-preview');
            const $svgInput = currentField.find('.ekwa-svg-input');

            // Show loading state
            $preview.html(`
                <i class="fas fa-spinner fa-spin"></i>
                <span class="ekwa-icon-class">Loading SVG...</span>
            `);

            // Fetch SVG from Font Awesome CDN
            fetchFontAwesomeSVG(iconClass)
                .then(svgCode => {
                    // Store SVG code
                    $valueInput.val(svgCode).trigger('change');
                    $typeInput.val('svg');
                    $svgInput.val(svgCode);

                    // Update preview
                    $preview.html(`
                        <div class="ekwa-icon-svg-preview">${svgCode}</div>
                        <span class="ekwa-icon-class">${iconClass.split(' ').pop().replace('fa-', '')}</span>
                    `);

                    // Trigger ACF update
                    if (typeof acf !== 'undefined') {
                        $valueInput.closest('.acf-field').trigger('change');
                    }

                    // Close modal and reset
                    $modal.fadeOut(200);
                    currentField = null;
                })
                .catch(error => {
                    console.error('Error fetching SVG:', error, 'Icon:', iconClass);

                    // Show error briefly then restore previous state
                    const previousValue = $valueInput.val();

                    $preview.html(`
                        <i class="fas fa-exclamation-triangle"></i>
                        <span class="ekwa-icon-class" style="color: red;">Failed to load icon</span>
                    `);

                    // Reset modal and restore after a moment
                    setTimeout(() => {
                        // Restore preview
                        if (previousValue && previousValue.includes('<svg')) {
                            $preview.html(`
                                <div class="ekwa-icon-svg-preview">${previousValue}</div>
                                <span class="ekwa-icon-class">SVG Icon</span>
                            `);
                        } else {
                            $preview.html(`
                                <i class="fas fa-icons"></i>
                                <span class="ekwa-icon-class">No icon selected</span>
                            `);
                        }

                        // Close modal and reset state
                        $modal.fadeOut(200);
                        currentField = null;
                    }, 1500);
                });
        });
    }

    // Load icons into grid
    function loadIcons($grid, category, search = '') {
        $grid.html('<div class="ekwa-loading"><i class="fas fa-spinner fa-spin"></i> Loading icons...</div>');

        setTimeout(() => {
            let icons = [];

            if (category === 'all') {
                icons = [...popularIcons.solid, ...popularIcons.regular, ...popularIcons.brands];
            } else {
                icons = popularIcons[category] || [];
            }

            // Filter by search
            if (search) {
                icons = icons.filter(icon => icon.toLowerCase().includes(search));
            }

            if (icons.length === 0) {
                $grid.html('<div class="ekwa-no-results">No icons found</div>');
                return;
            }

            let html = '';
            icons.forEach(iconClass => {
                const iconName = iconClass.split(' ').pop().replace('fa-', '');
                html += `
                    <div class="ekwa-icon-item" data-icon="${iconClass}" title="${iconName}">
                        <i class="${iconClass}"></i>
                        <span>${iconName}</span>
                    </div>
                `;
            });

            $grid.html(html);
        }, 100);
    }

    // Initialize on ACF ready
    if (typeof acf !== 'undefined') {
        acf.addAction('ready', initIconPicker);
        acf.addAction('append', initIconPicker);
    } else {
        $(document).ready(initIconPicker);
    }

})(jQuery);
