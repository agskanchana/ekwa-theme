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
            var $button = $(this);
            var $row = $button.closest('.repeater-row');

            // Get the row index
            var $allRows = $('#customize-control-location_info .repeater-row');
            var rowIndex = $allRows.index($row);
            console.log('Location Working Hours: Row index:', rowIndex);

            // Get the Kirki control value (contains all location data)
            var control = wp.customize.control('location_info');
            console.log('Location Working Hours: Control found:', !!control);

            if (!control) {
                alert('Could not access location data. Please refresh the page.');
                return;
            }

            var settingValue = control.setting.get();
            console.log('Location Working Hours: Setting type:', typeof settingValue);

            // Decode URL-encoded string and parse JSON
            var allLocations = settingValue;
            if (typeof settingValue === 'string') {
                try {
                    // First, decode the URL-encoded string
                    var decodedValue = decodeURIComponent(settingValue);
                    console.log('Location Working Hours: Decoded value (first 100 chars):', decodedValue.substring(0, 100));

                    // Then parse the JSON
                    allLocations = JSON.parse(decodedValue);
                    console.log('Location Working Hours: Parsed locations array:', allLocations.length);
                } catch(e) {
                    console.log('Location Working Hours: Parse error:', e);
                    alert('Error parsing location data. Please refresh the page.');
                    return;
                }
            }

            if (!allLocations[rowIndex]) {
                alert('Could not find location data for this row.');
                return;
            }

            var locationData = allLocations[rowIndex];
            console.log('Location Working Hours: Current working hours data:', locationData.working_hours_data);

            // Parse the working hours data
            var currentHours = [];
            try {
                currentHours = JSON.parse(locationData.working_hours_data || '[]');
            } catch(e) {
                console.log('Location Working Hours: Parse error, using empty array');
                currentHours = [];
            }

            // Open modal with callback to save
            openWorkingHoursModal(currentHours, function(newHours) {
                // Update the location data
                locationData.working_hours_data = JSON.stringify(newHours);
                allLocations[rowIndex] = locationData;

                // Save back to Kirki as JSON string (Kirki will handle encoding internally)
                var newValue = JSON.stringify(allLocations);
                console.log('Location Working Hours: Saving value (first 100 chars):', newValue.substring(0, 100));
                control.setting.set(newValue);

                // Update button text
                updateHoursCount(newHours, $button);

                console.log('Location Working Hours: Saved new hours');
            }, $button);
        });        // Try multiple approaches to find the fields

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
                    var labelText = $label.text().trim();
                    console.log('  Field', fieldIndex, 'label:', labelText || '(empty)');

                    // Check if this is the last field (working_hours_data)
                    // Or if description mentions "Working Hours"
                    var $description = $field.find('.description, .customize-control-description');
                    var descText = $description.text();

                    if (descText.indexOf('Working Hours') !== -1 || descText.indexOf('Edit Working Hours') !== -1) {
                        console.log('  Found Working Hours field by description!');
                        // This is our field! Add button here
                        // The code field creates a CodeMirror editor, let's just add the button to the field wrapper
                        $fields = $fields.add($field);
                    }
                });
            });
        }

        // Approach 3: If still nothing found, just target the last field in each row (it's working_hours_data)
        if ($fields.length === 0 && $locationControl.length) {
            console.log('Location Working Hours: Trying Approach 3 (by position - last field)...');
            $locationControl.find('.repeater-row').each(function() {
                var $lastField = $(this).find('.repeater-field').last();
                console.log('Location Working Hours: Using last field as working hours field');
                $fields = $fields.add($lastField);
            });
        }        console.log('Location Working Hours: Total fields found:', $fields.length);

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
        var fieldId = $field.attr('id') || 'field-' + Math.random();
        console.log('Location Working Hours: addWorkingHoursButton called for', fieldId);

        // Find the parent repeater row
        var $row = $field.closest('.repeater-row');

        // Check if button already exists in this row
        if ($row.find('.ekwa-hours-btn').length) {
            console.log('Location Working Hours: Button already exists in row');
            return;
        }

        // Create a prominent button with forced visibility
        var $buttonWrapper = $('<div class="ekwa-hours-button-wrapper" style="display: block !important; width: 100% !important; margin: 15px 0 !important; padding: 15px !important; background: #e7f5fe !important; border: 2px solid #0073aa !important; border-radius: 4px !important; text-align: center !important; box-sizing: border-box !important; clear: both !important;"></div>');
        var $button = $('<button type="button" class="button button-primary ekwa-hours-btn" style="display: inline-block !important; font-size: 14px !important; padding: 10px 24px !important; height: auto !important; line-height: 1.4 !important; cursor: pointer !important;"><span class="dashicons dashicons-clock" style="margin-right: 8px !important; vertical-align: middle !important;"></span>⏰ Edit Working Hours</button>');

        $button.attr('data-field-id', fieldId);
        $buttonWrapper.append($button);

        // Add to the ROW (not the field) - append to end of row
        $row.append($buttonWrapper);
        console.log('Location Working Hours: Button added successfully to row');
    }

    function updateHoursCount(data, $button) {
        try {
            var count = data.length;
            var countText = count === 0 ? ' (No hours set)' : ' (' + count + ' days configured)';
            $button.text('⏰ Edit Working Hours' + countText);
        } catch(e) {
            $button.text('⏰ Edit Working Hours');
        }
    }

    function openWorkingHoursModal(currentData, onSave, $button) {
        // Create modal
        var modal = createModal(currentData, function(newData) {
            onSave(newData);
            updateHoursCount(newData, $button);
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
