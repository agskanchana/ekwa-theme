(function() {
    'use strict';

    // Wait for both jQuery and wp.customize to be ready
    function initWhenReady() {
        if (typeof jQuery === 'undefined' || typeof wp === 'undefined' || typeof wp.customize === 'undefined') {
            setTimeout(initWhenReady, 100);
            return;
        }
        
        var $ = jQuery;
        console.log('Icon Picker: Dependencies loaded, initializing...');
        
        // Popular FontAwesome icons
        var popularIcons = [
            'home', 'user', 'envelope', 'phone', 'search', 'heart', 'star', 'cog', 'trash', 'edit',
            'check', 'times', 'plus', 'minus', 'calendar', 'clock', 'map-marker-alt', 'camera', 'image', 'video',
            'music', 'file', 'folder', 'download', 'upload', 'share', 'comment', 'bell', 'bookmark', 'tag',
            'shopping-cart', 'credit-card', 'gift', 'truck', 'plane', 'car', 'bicycle', 'train', 'bus', 'ship',
            'building', 'hospital', 'university', 'graduation-cap', 'book', 'briefcase', 'coffee', 'utensils', 'hamburger', 'pizza'
        ];

        var brandIcons = [
            'facebook-f', 'twitter', 'instagram', 'linkedin-in', 'youtube', 'pinterest-p', 'tiktok', 'snapchat',
            'whatsapp', 'telegram', 'reddit', 'tumblr', 'flickr', 'vimeo-v', 'spotify', 'soundcloud',
            'apple', 'android', 'windows', 'linux', 'chrome', 'firefox', 'safari', 'edge',
            'github', 'gitlab', 'bitbucket', 'stack-overflow', 'codepen', 'npm',
            'google', 'amazon', 'microsoft', 'paypal', 'stripe', 'shopify'
        ];

        // Wait for customizer to be ready
        wp.customize.bind('ready', function() {
            console.log('Icon Picker: Customizer ready, waiting 1s...');
            setTimeout(initIconPickers, 1000);
            
            // Re-initialize when Kirki adds new repeater rows
            $(document).on('click', '.repeater-row-add', function() {
                console.log('Icon Picker: New row added, reinitializing...');
                setTimeout(initIconPickers, 500);
            });
            
            // Also check when section is expanded
            $(document).on('click', '.accordion-section-title', function() {
                setTimeout(initIconPickers, 500);
            });
            
            // Re-initialize when repeater rows are expanded/toggled
            $(document).on('click', '.repeater-row .repeater-row-header', function() {
                setTimeout(initIconPickers, 300);
            });
            
            // Watch for DOM changes in the social media control
            var observer = new MutationObserver(function(mutations) {
                var shouldReinit = false;
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length > 0) {
                        shouldReinit = true;
                    }
                });
                if (shouldReinit) {
                    setTimeout(initIconPickers, 300);
                }
            });
            
            // Start observing when control exists
            setTimeout(function() {
                var controlEl = document.getElementById('customize-control-social_media_links');
                if (controlEl) {
                    observer.observe(controlEl, { childList: true, subtree: true });
                    console.log('Icon Picker: MutationObserver attached to social_media_links');
                }
            }, 2000);
        });

        function initIconPickers() {
            console.log('Icon Picker: Running initIconPickers...');
            
            // Debug: Check if control exists
            var $control = $('#customize-control-social_media_links');
            console.log('Icon Picker: Control found:', $control.length);
            
            if ($control.length) {
                console.log('Icon Picker: Repeater rows:', $control.find('.repeater-row').length);
            }
            
            // Find all text inputs in social media repeater, then filter by label
            var foundInputs = [];
            var allLabels = [];
            
            // Find by traversing from labels
            $('#customize-control-social_media_links .repeater-row').each(function(rowIndex) {
                var $row = $(this);
                console.log('Icon Picker: Processing row', rowIndex, 'fields:', $row.find('.repeater-field').length);
                
                $row.find('.repeater-field').each(function(fieldIndex) {
                    var $field = $(this);
                    var $label = $field.find('label').first();
                    var labelText = $label.text().trim();
                    allLabels.push(labelText);
                    
                    console.log('  Field', fieldIndex, 'label:', labelText);
                    
                    if (labelText === 'Social Media Icon (Font)' || labelText.indexOf('Icon') > -1) {
                        var $input = $field.find('input[type="text"]');
                        console.log('  Found potential icon field, input:', $input.length);
                        if ($input.length && !$input.data('icon-picker-init')) {
                            foundInputs.push($input);
                            console.log('  Added to foundInputs');
                        }
                    }
                });
            });
            
            console.log('Icon Picker: All labels found:', allLabels);
            console.log('Icon Picker: Matching inputs found:', foundInputs.length);
            
            // Process each found input
            foundInputs.forEach(function($input) {
                if ($input.data('icon-picker-init')) return;
                $input.data('icon-picker-init', true);
                
                console.log('Icon Picker: Initializing input');

                // Create wrapper and controls
                var $wrapper = $('<div class="kirki-icon-picker-wrapper"></div>');
                var $preview = $('<div class="kirki-icon-preview"><i class="fa-regular fa-icons fa-2x" style="opacity: 0.3;"></i></div>');
                var $controls = $('<div class="kirki-icon-controls"></div>');
                var $browseBtn = $('<button type="button" class="button kirki-icon-browse">Browse Icons</button>');
                var $clearBtn = $('<button type="button" class="button kirki-icon-clear" style="display:none;">Clear</button>');
                var $selectedText = $('<div class="kirki-icon-selected-text"><span style="opacity: 0.5;">No icon selected</span></div>');

                // Update preview if field has value
                if ($input.val()) {
                    $preview.find('i').attr('class', $input.val() + ' fa-2x').css('opacity', '1');
                    $selectedText.html('<code>' + $input.val() + '</code>');
                    $clearBtn.show();
                }

                // Build structure
                $input.after($wrapper);
                $controls.append($browseBtn).append($clearBtn);
                $wrapper.append($preview).append($controls).append($selectedText);
                $input.appendTo($controls).css({'flex': '1', 'margin-right': '5px'});

                // Create modal if it doesn't exist
                if ($('#kirki-icon-modal').length === 0) {
                    var modalHTML = '<div id="kirki-icon-modal" class="kirki-icon-modal" style="display: none;">' +
                        '<div class="kirki-icon-modal-overlay"></div>' +
                        '<div class="kirki-icon-modal-content">' +
                        '<div class="kirki-icon-modal-header">' +
                        '<h2>Select Icon</h2>' +
                        '<input type="text" class="kirki-icon-modal-search" placeholder="Search icons..." />' +
                        '<button type="button" class="kirki-icon-modal-close">&times;</button>' +
                        '</div>' +
                        '<div class="kirki-icon-modal-body">' +
                        '<div class="kirki-icon-style-tabs">' +
                        '<button class="kirki-icon-tab active" data-style="solid">Solid</button>' +
                        '<button class="kirki-icon-tab" data-style="regular">Regular</button>' +
                        '<button class="kirki-icon-tab" data-style="brands">Brands</button>' +
                        '</div>' +
                        '<div class="kirki-icon-grid"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $('body').append(modalHTML);
                }

                setupIconPickerEvents($input, $preview, $selectedText, $browseBtn, $clearBtn);
            });
        }

        function setupIconPickerEvents($input, $preview, $selectedText, $browseBtn, $clearBtn) {
            // Browse button click
            $browseBtn.on('click', function(e) {
                e.preventDefault();
                openModal($input, $preview, $selectedText, $clearBtn);
            });

            // Clear button click
            $clearBtn.on('click', function(e) {
                e.preventDefault();
                $input.val('').trigger('change');
                $preview.find('i').attr('class', 'fa-regular fa-icons fa-2x').css('opacity', '0.3');
                $selectedText.html('<span style="opacity: 0.5;">No icon selected</span>');
                $(this).hide();
            });

            // Input change
            $input.on('change keyup', function() {
                var value = $input.val().trim();
                if (value) {
                    $preview.find('i').attr('class', value + ' fa-2x').css('opacity', '1');
                    $selectedText.html('<code>' + value + '</code>');
                    $clearBtn.show();
                } else {
                    $preview.find('i').attr('class', 'fa-regular fa-icons fa-2x').css('opacity', '0.3');
                    $selectedText.html('<span style="opacity: 0.5;">No icon selected</span>');
                    $clearBtn.hide();
                }
            });
        }

        function openModal($input, $preview, $selectedText, $clearBtn) {
            var $modal = $('#kirki-icon-modal');
            $modal.show();

            var $grid = $modal.find('.kirki-icon-grid');
            var $modalSearch = $modal.find('.kirki-icon-modal-search');
            var $tabs = $modal.find('.kirki-icon-tab');
            var currentStyle = 'solid';

            // Load icons
            loadIcons($grid, currentStyle);

            // Tab click
            $tabs.off('click').on('click', function() {
                $tabs.removeClass('active');
                $(this).addClass('active');
                currentStyle = $(this).data('style');
                loadIcons($grid, currentStyle);
                $modalSearch.val('');
            });

            // Modal search
            $modalSearch.off('keyup').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $grid.find('.kirki-icon-item').each(function() {
                    var iconName = $(this).data('icon-name');
                    if (iconName.indexOf(searchTerm) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Icon click
            $grid.off('click', '.kirki-icon-item').on('click', '.kirki-icon-item', function() {
                var iconClass = $(this).data('icon-class');
                $input.val(iconClass).trigger('change');
                $preview.find('i').attr('class', iconClass + ' fa-2x').css('opacity', '1');
                $selectedText.html('<code>' + iconClass + '</code>');
                $clearBtn.show();
                $modal.hide();
            });

            // Close modal
            $modal.find('.kirki-icon-modal-close, .kirki-icon-modal-overlay').off('click').on('click', function() {
                $modal.hide();
            });
        }

        function loadIcons($grid, style) {
            $grid.html('<div class="kirki-icon-loading">Loading icons...</div>');

            var icons = style === 'brands' ? brandIcons : popularIcons;
            var stylePrefix = style === 'brands' ? 'fa-brands' : (style === 'regular' ? 'fa-regular' : 'fa-solid');

            setTimeout(function() {
                var html = '';
                icons.forEach(function(icon) {
                    var iconClass = stylePrefix + ' fa-' + icon;
                    html += '<div class="kirki-icon-item" data-icon-class="' + iconClass + '" data-icon-name="' + icon + '">';
                    html += '<i class="' + iconClass + '"></i>';
                    html += '<span>' + icon + '</span>';
                    html += '</div>';
                });
                $grid.html(html);
            }, 100);
        }
    }
    
    // Start initialization
    initWhenReady();
    
})();
