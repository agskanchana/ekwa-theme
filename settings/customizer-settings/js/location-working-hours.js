/**
 * Location Working Hours Manager
 * Adds nested working hours functionality to location repeater items
 */

(function() {
    'use strict';

    // Wait for jQuery to be available
    if (typeof jQuery === 'undefined') {
        console.log('Location Working Hours: jQuery not ready, waiting...');
        setTimeout(arguments.callee, 100);
        return;
    }

    var $ = jQuery;
    var processedFields = new Set();

    console.log('Location Working Hours: jQuery loaded, initializing...');

    // Wait for Kirki to initialize
    $(document).ready(function() {
        console.log('Location Working Hours: Document ready');
        setTimeout(initWorkingHoursManager, 1000);
        setTimeout(initWorkingHoursManager, 3000);
        setTimeout(initWorkingHoursManager, 5000);

        // Watch for DOM changes in the location control
        if (window.MutationObserver) {
            var observer = new MutationObserver(function(mutations) {
                initWorkingHoursManager();
            });

            setTimeout(function() {
                var $locationControl = $('#customize-control-location_info');
                if ($locationControl.length) {
                    observer.observe($locationControl[0], {
                        childList: true,
                        subtree: true
                    });
                    console.log('Location Working Hours: Mutation observer attached');
                }
            }, 2000);
        }
    });

    function initWorkingHoursManager() {
        console.log('Location Working Hours: Running init manager...');

        // Use event delegation for dynamically added rows
        $(document).off('click.ekwa-hours').on('click.ekwa-hours', '.ekwa-hours-btn', function(e) {
            e.preventDefault();
            console.log('Location Working Hours: Button clicked');
            var $textarea = $(this).data('textarea');
            if ($textarea && $textarea.length) {
                openWorkingHoursModal($textarea, $(this));
            }
        });

        // Try multiple approaches to find the fields

        // First, let's see if the location control exists
        var $locationControl = $('#customize-control-location_info');
        console.log('Location Working Hours: Location control exists:', $locationControl.length);

        if ($locationControl.length) {
            console.log('Location Working Hours: Repeater rows found:', $locationControl.find('.repeater-row').length);
            console.log('Location Working Hours: Repeater fields found:', $locationControl.find('.repeater-field').length);
        }

        // Approach 1: Find by textarea ID
        var $fields = $('textarea[id*="working_hours_data"]');
        console.log('Location Working Hours: Approach 1 (textarea[id*=...]) found:', $fields.length);

        // Approach 2: Find CodeMirror instances in location repeater
        if ($fields.length === 0 && $locationControl.length) {
            console.log('Location Working Hours: Trying Approach 2 (by label)...');
            $locationControl.find('.repeater-row').each(function(rowIndex) {
                var $row = $(this);
                console.log('Location Working Hours: Processing row', rowIndex, '- fields:', $row.find('.repeater-field').length);

                // Look for any textarea or CodeMirror in this row that might be the working hours field
                $row.find('.repeater-field').each(function(fieldIndex) {
                    var $field = $(this);
                    var $label = $field.find('label');
                    var labelText = $label.text();
                    console.log('  Field', fieldIndex, 'label:', labelText);

                    if (labelText.indexOf('Working Hours') !== -1) {
                        console.log('  Found Working Hours field!');
                        var $textarea = $field.find('textarea');
                        console.log('  Textarea found:', $textarea.length);
                        if ($textarea.length) {
                            $fields = $fields.add($textarea);
                            console.log('Location Working Hours: Found field by label');
                        }
                    }
                });
            });
        }

        // Approach 3: Find by looking at the last field in each repeater row (working_hours_data is the last field)
        if ($fields.length === 0 && $locationControl.length) {
            console.log('Location Working Hours: Trying Approach 3 (last field)...');
            $locationControl.find('.repeater-row').each(function() {
                var $lastField = $(this).find('.repeater-field').last();
                console.log('Location Working Hours: Last field has textarea:', $lastField.find('textarea').length);
                var $textarea = $lastField.find('textarea');
                if ($textarea.length) {
                    // Check if this textarea's ID or name contains working_hours
                    var id = $textarea.attr('id') || '';
                    var name = $textarea.attr('name') || '';
                    console.log('Location Working Hours: Last field ID:', id, 'Name:', name);
                    if (id.indexOf('working_hours') !== -1 || name.indexOf('working_hours') !== -1) {
                        $fields = $fields.add($textarea);
                        console.log('Location Working Hours: Found field as last in repeater');
                    }
                }
            });
        }

        console.log('Location Working Hours: Total fields found:', $fields.length);

        $fields.each(function() {
            var fieldId = $(this).attr('id') || 'field-' + Math.random();
            if (!processedFields.has(fieldId)) {
                processedFields.add(fieldId);
                console.log('Location Working Hours: Adding button to field:', fieldId);
                addWorkingHoursButton($(this));
            }
        });
    }

    function addWorkingHoursButton($field) {
        // Check if button already exists
        if ($field.siblings('.ekwa-hours-btn').length || $field.parent().find('.ekwa-hours-btn').length) {
            return;
        }

        var $textarea = $field;
        if (!$textarea.is('textarea')) {
            $textarea = $field.find('textarea');
        }

        if (!$textarea.length) {
            return;
        }

        // Find the parent container
        var $container = $textarea.parent();

        // Create button
        var $button = $('<button type="button" class="button button-secondary ekwa-hours-btn" style="margin-top: 10px; display: block; width: 100%;">📅 Edit Working Hours</button>');

        // Store reference to textarea
        $button.data('textarea', $textarea);

        // Add button to container
        $container.append($button);

        // Hide the textarea/code editor
        $textarea.css({
            'height': '0',
            'min-height': '0',
            'border': 'none',
            'padding': '0',
            'overflow': 'hidden',
            'opacity': '0'
        });

        // Hide CodeMirror editor if present
        $container.find('.CodeMirror').css({
            'height': '0',
            'min-height': '0',
            'overflow': 'hidden',
            'opacity': '0'
        });

        // Update count
        updateHoursCount($textarea, $button);

        // Watch for changes to update count
        $textarea.on('change', function() {
            updateHoursCount($textarea, $button);
        });
    }

    function updateHoursCount($textarea, $button) {
        try {
            var data = JSON.parse($textarea.val() || '[]');
            var count = data.length;
            var countText = count === 0 ? ' (No hours set)' : ' (' + count + ' days configured)';
            $button.text('📅 Edit Working Hours' + countText);
        } catch(e) {
            $button.text('📅 Edit Working Hours');
        }
    }

    function openWorkingHoursModal($textarea, $button) {
        var currentData = [];
        try {
            currentData = JSON.parse($textarea.val() || '[]');
        } catch(e) {
            currentData = [];
        }

        // Create modal
        var modal = createModal(currentData, function(newData) {
            $textarea.val(JSON.stringify(newData)).trigger('change');
            updateHoursCount($textarea, $button);
        });

        $('body').append(modal);
        modal.fadeIn(200);
    }

    function createModal(data, onSave) {
        var $modal = $('<div class="ekwa-hours-modal"></div>').css({
            'position': 'fixed',
            'top': '0',
            'left': '0',
            'width': '100%',
            'height': '100%',
            'background': 'rgba(0,0,0,0.7)',
            'z-index': '999999',
            'display': 'none'
        });

        var $content = $('<div class="ekwa-hours-content"></div>').css({
            'position': 'absolute',
            'top': '50%',
            'left': '50%',
            'transform': 'translate(-50%, -50%)',
            'background': '#fff',
            'padding': '30px',
            'border-radius': '8px',
            'max-width': '700px',
            'width': '90%',
            'max-height': '80vh',
            'overflow-y': 'auto',
            'box-shadow': '0 10px 40px rgba(0,0,0,0.3)'
        });

        var html = '<h2 style="margin-top:0; margin-bottom:20px;">Working Hours Manager</h2>';
        html += '<div class="ekwa-hours-list" style="margin-bottom:20px;"></div>';
        html += '<button type="button" class="button ekwa-add-hour-btn" style="margin-bottom:20px;">+ Add Working Hour</button>';
        html += '<div style="margin-top:20px; padding-top:20px; border-top:1px solid #ddd; text-align:right;">';
        html += '<button type="button" class="button button-secondary ekwa-cancel-btn" style="margin-right:10px;">Cancel</button>';
        html += '<button type="button" class="button button-primary ekwa-save-btn">Save Working Hours</button>';
        html += '</div>';

        $content.html(html);
        $modal.append($content);

        var $list = $content.find('.ekwa-hours-list');

        // Render existing data
        data.forEach(function(item) {
            addHourRow($list, item);
        });

        // Add new hour button
        $content.on('click', '.ekwa-add-hour-btn', function() {
            addHourRow($list, {
                day: 'Monday',
                closed: false,
                opening: '09:00',
                closing: '17:00',
                opening_period: 'AM',
                closing_period: 'PM',
                extra_text: ''
            });
        });

        // Remove hour row
        $content.on('click', '.ekwa-remove-hour', function() {
            $(this).closest('.ekwa-hour-row').slideUp(200, function() {
                $(this).remove();
            });
        });

        // Handle closed checkbox toggle
        $content.on('change', '.hour-closed', function() {
            var $times = $(this).closest('.ekwa-hour-row').find('.hour-times');
            if ($(this).is(':checked')) {
                $times.slideUp(200);
            } else {
                $times.slideDown(200);
            }
        });

        // Handle save
        $content.on('click', '.ekwa-save-btn', function() {
            var newData = [];
            $list.find('.ekwa-hour-row').each(function() {
                var day = $(this).find('.hour-day').val();
                var closed = $(this).find('.hour-closed').is(':checked');
                var openingHour = $(this).find('.hour-opening-hour').val();
                var openingMinute = $(this).find('.hour-opening-minute').val();
                var openingPeriod = $(this).find('.hour-opening-period').val();
                var closingHour = $(this).find('.hour-closing-hour').val();
                var closingMinute = $(this).find('.hour-closing-minute').val();
                var closingPeriod = $(this).find('.hour-closing-period').val();
                var extra_text = $(this).find('.hour-extra').val();

                var opening = openingHour + ':' + openingMinute + ' ' + openingPeriod;
                var closing = closingHour + ':' + closingMinute + ' ' + closingPeriod;

                newData.push({
                    day: day,
                    closed: closed,
                    opening: opening,
                    closing: closing,
                    extra_text: extra_text
                });
            });

            onSave(newData);
            $modal.fadeOut(200, function() {
                $modal.remove();
            });
        });

        // Handle cancel
        $content.on('click', '.ekwa-cancel-btn', function() {
            $modal.fadeOut(200, function() {
                $modal.remove();
            });
        });

        // Close on background click
        $modal.on('click', function(e) {
            if ($(e.target).hasClass('ekwa-hours-modal')) {
                $modal.fadeOut(200, function() {
                    $modal.remove();
                });
            }
        });

        return $modal;
    }

    function addHourRow($list, item) {
        var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Parse time
        var opening = item.opening || '09:00 AM';
        var closing = item.closing || '05:00 PM';

        var openingParts = parseTime(opening);
        var closingParts = parseTime(closing);

        var html = '<div class="ekwa-hour-row" style="margin-bottom:15px; padding:15px; border:1px solid #ddd; border-radius:5px; background:#f9f9f9;">';

        // Header with day selector and controls
        html += '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">';
        html += '<select class="hour-day" style="padding:5px; font-size:14px; font-weight:bold;">';
        days.forEach(function(day) {
            html += '<option value="' + day + '" ' + (item.day === day ? 'selected' : '') + '>' + day + '</option>';
        });
        html += '</select>';
        html += '<div>';
        html += '<label style="cursor:pointer; margin-right:10px;"><input type="checkbox" class="hour-closed" ' + (item.closed ? 'checked' : '') + '> Closed</label>';
        html += '<button type="button" class="button ekwa-remove-hour" style="padding:2px 8px; font-size:12px; background:#dc3232; color:#fff; border-color:#dc3232;">Remove</button>';
        html += '</div>';
        html += '</div>';

        // Time inputs
        html += '<div class="hour-times" style="' + (item.closed ? 'display:none;' : '') + '">';

        // Opening time
        html += '<div style="margin-bottom:10px; display:flex; align-items:center;">';
        html += '<label style="display:inline-block; width:80px; font-weight:500;">Opening:</label>';
        html += '<select class="hour-opening-hour" style="padding:5px; margin-right:2px; width:60px;">';
        for (var h = 1; h <= 12; h++) {
            var hStr = h.toString().padStart(2, '0');
            html += '<option value="' + hStr + '" ' + (openingParts.hour === hStr ? 'selected' : '') + '>' + hStr + '</option>';
        }
        html += '</select>';
        html += '<span style="margin:0 2px;">:</span>';
        html += '<select class="hour-opening-minute" style="padding:5px; margin-right:5px; width:60px;">';
        ['00', '15', '30', '45'].forEach(function(min) {
            html += '<option value="' + min + '" ' + (openingParts.minute === min ? 'selected' : '') + '>' + min + '</option>';
        });
        html += '</select>';
        html += '<select class="hour-opening-period" style="padding:5px; width:60px;">';
        html += '<option value="AM" ' + (openingParts.period === 'AM' ? 'selected' : '') + '>AM</option>';
        html += '<option value="PM" ' + (openingParts.period === 'PM' ? 'selected' : '') + '>PM</option>';
        html += '</select>';
        html += '</div>';

        // Closing time
        html += '<div style="margin-bottom:10px; display:flex; align-items:center;">';
        html += '<label style="display:inline-block; width:80px; font-weight:500;">Closing:</label>';
        html += '<select class="hour-closing-hour" style="padding:5px; margin-right:2px; width:60px;">';
        for (var h = 1; h <= 12; h++) {
            var hStr = h.toString().padStart(2, '0');
            html += '<option value="' + hStr + '" ' + (closingParts.hour === hStr ? 'selected' : '') + '>' + hStr + '</option>';
        }
        html += '</select>';
        html += '<span style="margin:0 2px;">:</span>';
        html += '<select class="hour-closing-minute" style="padding:5px; margin-right:5px; width:60px;">';
        ['00', '15', '30', '45'].forEach(function(min) {
            html += '<option value="' + min + '" ' + (closingParts.minute === min ? 'selected' : '') + '>' + min + '</option>';
        });
        html += '</select>';
        html += '<select class="hour-closing-period" style="padding:5px; width:60px;">';
        html += '<option value="AM" ' + (closingParts.period === 'AM' ? 'selected' : '') + '>AM</option>';
        html += '<option value="PM" ' + (closingParts.period === 'PM' ? 'selected' : '') + '>PM</option>';
        html += '</select>';
        html += '</div>';

        // Extra text
        html += '<div>';
        html += '<label style="display:inline-block; width:80px; font-weight:500;">Extra Note:</label>';
        html += '<input type="text" class="hour-extra" value="' + (item.extra_text || '') + '" placeholder="e.g., By appointment only" style="padding:5px; width:calc(100% - 85px);">';
        html += '</div>';

        html += '</div>';
        html += '</div>';

        $list.append(html);
    }

    function parseTime(timeStr) {
        // Parse time like "09:00 AM" or "09:00" or "9:00 AM"
        var parts = {
            hour: '09',
            minute: '00',
            period: 'AM'
        };

        if (!timeStr) return parts;

        var match = timeStr.match(/(\d+):(\d+)\s*(AM|PM)?/i);
        if (match) {
            parts.hour = match[1].padStart(2, '0');
            parts.minute = match[2].padStart(2, '0');
            if (match[3]) {
                parts.period = match[3].toUpperCase();
            }
        }

        return parts;
    }

})();
