/**
 * EKWA Site Setup Wizard — JavaScript
 *
 * Multi-step form handling: navigation, dynamic location repeater with
 * working-hours sub-tables, social-media fields, header/footer select,
 * and AJAX saves per step.
 */

(function ($) {
	'use strict';

	/* -----------------------------------------------------------------
	 * Time options for working-hours selects
	 * ----------------------------------------------------------------*/
	var TIME_OPTIONS = [
		'', '6:00 AM', '6:30 AM', '7:00 AM', '7:30 AM',
		'8:00 AM', '8:30 AM', '9:00 AM', '9:30 AM',
		'10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM',
		'12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM',
		'2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM',
		'4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM',
		'6:00 PM', '6:30 PM', '7:00 PM', '7:30 PM',
		'8:00 PM', '8:30 PM', '9:00 PM'
	];

	var DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

	var DEFAULT_HOURS = {
		Monday:    { opening: '8:00 AM', closing: '5:00 PM', closed: false },
		Tuesday:   { opening: '8:00 AM', closing: '5:00 PM', closed: false },
		Wednesday: { opening: '8:00 AM', closing: '5:00 PM', closed: false },
		Thursday:  { opening: '8:00 AM', closing: '5:00 PM', closed: false },
		Friday:    { opening: '8:00 AM', closing: '5:00 PM', closed: false },
		Saturday:  { opening: '9:00 AM', closing: '1:00 PM', closed: false },
		Sunday:    { opening: '',         closing: '',         closed: true  }
	};

	/* -----------------------------------------------------------------
	 * Main controller
	 * ----------------------------------------------------------------*/

	var Setup = {
		step: 1,
		locationIndex: 0,

		init: function () {
			this.prefill();
			this.bindEvents();
			this.ensureLocation();
			this.populateHeaderFooter();
		},

		/* ==============================================================
		 * Events
		 * ============================================================*/

		bindEvents: function () {
			// Step navigation buttons
			$('#save-step-1').on('click', function () { Setup.saveStep(1); });
			$('#save-step-2').on('click', function () { Setup.saveStep(2); });
			$('#save-step-3').on('click', function () { Setup.saveStep(3); });
			$('#save-step-4').on('click', function () { Setup.saveStep(4); });

			$('#back-step-2').on('click', function () { Setup.goTo(1); });
			$('#back-step-3').on('click', function () { Setup.goTo(2); });
			$('#back-step-4').on('click', function () { Setup.goTo(3); });

			// Location repeater
			$('#ekwa-add-location').on('click', function () { Setup.addLocation(); });
			$(document).on('click', '.remove-location', function () {
				$(this).closest('.ekwa-location-card').remove();
				Setup.renumberLocations();
			});
			$(document).on('click', '.ekwa-location-card-header', function (e) {
				if ($(e.target).closest('.remove-location').length) return;
				$(this).closest('.ekwa-location-card').toggleClass('collapsed');
			});

			// Closed checkbox toggles row styling
			$(document).on('change', '.day-closed-cb', function () {
				var $row = $(this).closest('tr');
				$row.toggleClass('day-closed', this.checked);
			});

			// Appointment type toggle
			$('input[name="appointment_page_type"]').on('change', function () {
				$('#appointment-url-wrap').toggle($(this).val() === 'external');
			});

			// Skip
			$('#ekwa-skip-setup').on('click', function (e) {
				e.preventDefault();
				if (!confirm('Skip setup? You can complete it later via Appearance → Site Setup, or directly in the Customizer.')) return;
				$.post(ekwaSiteSetup.ajaxurl, {
					action: 'ekwa_site_setup_skip',
					nonce: ekwaSiteSetup.nonce
				}, function () {
					window.location.href = ekwaSiteSetup.adminUrl;
				});
			});
		},

		/* ==============================================================
		 * Pre-fill from existing theme_mods
		 * ============================================================*/

		prefill: function () {
			var d = ekwaSiteSetup.existing || {};

			// Step 1 fields
			if (d.client_name)           $('#client_name').val(d.client_name);
			if (d.practise_name)         $('#practise_name').val(d.practise_name);
			if (d.organization_type)     $('#organization_type').val(d.organization_type);
			if (d.email_address)         $('#email_address').val(d.email_address);
			if (d.country)               $('#country').val(d.country);
			if (d.appointment_page_type) {
				$('input[name="appointment_page_type"][value="' + d.appointment_page_type + '"]').prop('checked', true);
				$('#appointment-url-wrap').toggle(d.appointment_page_type === 'external');
			}
			if (d.appointment_external_url) $('#appointment_external_url').val(d.appointment_external_url);

			// Step 2 — locations (will be added via addLocation)
			// handled in ensureLocation()

			// Step 3 — social media
			if (d.social_media_links && d.social_media_links.length) {
				var nameToKey = {
					'Facebook': 'facebook', 'Instagram': 'instagram',
					'X (Twitter)': 'twitter', 'Twitter': 'twitter',
					'YouTube': 'youtube', 'LinkedIn': 'linkedin',
					'TikTok': 'tiktok', 'Yelp': 'yelp'
				};
				$.each(d.social_media_links, function (_, item) {
					var key = nameToKey[item.profile_name] || '';
					if (key && item.social_media_link) {
						$('input[name="social_' + key + '"]').val(item.social_media_link);
					}
				});
			}
		},

		/* ==============================================================
		 * Location repeater
		 * ============================================================*/

		ensureLocation: function () {
			var existing = ekwaSiteSetup.existing.location_info;
			if (existing && existing.length) {
				for (var i = 0; i < existing.length; i++) {
					this.addLocation(existing[i]);
				}
			} else {
				this.addLocation(); // blank card
			}
		},

		addLocation: function (data) {
			this.locationIndex++;
			var idx = this.locationIndex;
			var label = 'Location ' + idx;

			var hours = DEFAULT_HOURS;
			if (data && data.working_hours_data) {
				try {
					var parsed = typeof data.working_hours_data === 'string'
						? JSON.parse(data.working_hours_data)
						: data.working_hours_data;
					if (Array.isArray(parsed)) {
						hours = {};
						$.each(parsed, function (_, h) {
							hours[h.day] = { opening: h.opening || '', closing: h.closing || '', closed: !!h.closed };
						});
					}
				} catch (e) { /* keep defaults */ }
			}

			var html = '<div class="ekwa-location-card" data-idx="' + idx + '">';
			html += '<div class="ekwa-location-card-header">';
			html += '<h3>' + label + '</h3>';
			html += '<span class="toggle-icon">&#9660;</span>';
			if (idx > 1) html += '<button type="button" class="remove-location">&times; Remove</button>';
			html += '</div>';
			html += '<div class="ekwa-location-card-body">';

			// Fields grid
			html += '<div class="ekwa-form-grid">';
			html += this.fieldHtml(idx, 'phone', 'New Patients Phone *', 'tel', data ? data.phone : '', '(555) 123-4567');
			html += this.fieldHtml(idx, 'phone_ex', 'Existing Patients Phone', 'tel', data ? data.phone_ex : '', '(555) 123-4568');
			html += this.fieldHtml(idx, 'street_address', 'Street Address *', 'text', data ? data.street_address : '', '123 Main St Suite 200');
			html += this.fieldHtml(idx, 'city', 'City *', 'text', data ? data.city : '', 'Austin');
			html += this.fieldHtml(idx, 'state', 'State / Province *', 'text', data ? data.state : '', 'TX');
			html += this.fieldHtml(idx, 'zip', 'Zip / Postal Code *', 'text', data ? data.zip : '', '78701');
			html += this.fieldHtml(idx, 'direction', 'Google Maps URL', 'url', data ? data.direction : '', 'https://maps.google.com/...');
			html += this.fieldHtml(idx, 'latitude', 'Latitude', 'text', data ? data.latitude : '', '30.2672');
			html += this.fieldHtml(idx, 'longitude', 'Longitude', 'text', data ? data.longitude : '', '-97.7431');
			html += '</div>'; // .ekwa-form-grid

			// Working hours
			html += '<div class="hours-heading">Working Hours</div>';
			html += this.hoursTableHtml(idx, hours);

			html += '</div>'; // .ekwa-location-card-body
			html += '</div>'; // .ekwa-location-card

			$('#ekwa-locations-list').append(html);
		},

		fieldHtml: function (idx, name, label, type, value, placeholder) {
			return '<div class="ekwa-field">' +
				'<label>' + label + '</label>' +
				'<input type="' + type + '" data-loc="' + idx + '" data-field="' + name + '" ' +
				'value="' + this.esc(value || '') + '" placeholder="' + this.esc(placeholder || '') + '">' +
				'</div>';
		},

		hoursTableHtml: function (idx, hours) {
			var html = '<table class="ekwa-hours-table"><thead><tr>' +
				'<th>Day</th><th>Open</th><th>Close</th><th>Closed</th></tr></thead><tbody>';

			for (var d = 0; d < DAYS.length; d++) {
				var day = DAYS[d];
				var h = hours[day] || { opening: '', closing: '', closed: false };
				var closedClass = h.closed ? ' day-closed' : '';
				var checked = h.closed ? ' checked' : '';

				html += '<tr class="' + closedClass + '">';
				html += '<td class="day-name">' + day + '</td>';
				html += '<td>' + this.timeSelect(idx, day, 'opening', h.opening) + '</td>';
				html += '<td>' + this.timeSelect(idx, day, 'closing', h.closing) + '</td>';
				html += '<td><input type="checkbox" class="day-closed-cb" data-loc="' + idx + '" data-day="' + day + '"' + checked + '></td>';
				html += '</tr>';
			}

			html += '</tbody></table>';
			return html;
		},

		timeSelect: function (idx, day, field, selected) {
			var html = '<select data-loc="' + idx + '" data-day="' + day + '" data-timefield="' + field + '">';
			for (var i = 0; i < TIME_OPTIONS.length; i++) {
				var t = TIME_OPTIONS[i];
				var sel = (t === selected) ? ' selected' : '';
				var label = t || '—';
				html += '<option value="' + t + '"' + sel + '>' + label + '</option>';
			}
			html += '</select>';
			return html;
		},

		renumberLocations: function () {
			$('.ekwa-location-card').each(function (i) {
				$(this).find('.ekwa-location-card-header h3').text('Location ' + (i + 1));
			});
		},

		/* ==============================================================
		 * Header / Footer dropdowns
		 * ============================================================*/

		populateHeaderFooter: function () {
			var $hdr = $('#select_header');
			var $ftr = $('#select_footer');

			$.each(ekwaSiteSetup.headers, function (_, h) {
				var sel = (String(h.id) === String(ekwaSiteSetup.currentHeader)) ? ' selected' : '';
				$hdr.append('<option value="' + h.id + '"' + sel + '>' + Setup.esc(h.title) + ' (ID ' + h.id + ')</option>');
			});
			$.each(ekwaSiteSetup.footers, function (_, f) {
				var sel = (String(f.id) === String(ekwaSiteSetup.currentFooter)) ? ' selected' : '';
				$ftr.append('<option value="' + f.id + '"' + sel + '>' + Setup.esc(f.title) + ' (ID ' + f.id + ')</option>');
			});
		},

		/* ==============================================================
		 * Collect data per step
		 * ============================================================*/

		collectStep1: function () {
			return {
				client_name:              $('#client_name').val(),
				practise_name:            $('#practise_name').val(),
				organization_type:        $('#organization_type').val(),
				email_address:            $('#email_address').val(),
				country:                  $('#country').val(),
				appointment_page_type:    $('input[name="appointment_page_type"]:checked').val(),
				appointment_external_url: $('#appointment_external_url').val()
			};
		},

		collectStep2: function () {
			var locations = [];
			$('.ekwa-location-card').each(function () {
				var $card = $(this);
				var idx = $card.data('idx');
				var loc = {};

				// Simple fields
				$card.find('input[data-loc="' + idx + '"]').each(function () {
					var field = $(this).data('field');
					if (field) loc[field] = $(this).val();
				});

				// Working hours
				var hours = [];
				for (var d = 0; d < DAYS.length; d++) {
					var day = DAYS[d];
					var opening = $card.find('select[data-loc="' + idx + '"][data-day="' + day + '"][data-timefield="opening"]').val() || '';
					var closing = $card.find('select[data-loc="' + idx + '"][data-day="' + day + '"][data-timefield="closing"]').val() || '';
					var closed  = $card.find('input.day-closed-cb[data-loc="' + idx + '"][data-day="' + day + '"]').is(':checked');
					hours.push({
						day: day,
						opening: closed ? '' : opening,
						closing: closed ? '' : closing,
						closed: closed,
						extra_text: ''
					});
				}
				loc.working_hours_data = JSON.stringify(hours);

				locations.push(loc);
			});
			return { locations: locations };
		},

		collectStep3: function () {
			var social = {};
			$('.ekwa-social-row').each(function () {
				var key = $(this).data('platform');
				var val = $(this).find('input[type="url"]').val();
				if (key) social[key] = val || '';
			});
			return { social: social };
		},

		collectStep4: function () {
			return {
				select_header: $('#select_header').val(),
				select_footer: $('#select_footer').val()
			};
		},

		/* ==============================================================
		 * Validation
		 * ============================================================*/

		validateStep1: function () {
			var ok = true;
			$('#setup-step-1 .field-error').removeClass('field-error');
			$('.ekwa-inline-error').remove();

			var name = $('#practise_name').val().trim();
			var client = $('#client_name').val().trim();
			if (!client) { $('#client_name').addClass('field-error'); ok = false; }
			if (!name)   { $('#practise_name').addClass('field-error'); ok = false; }

			if (!ok) {
				$('#setup-step-1 .ekwa-step-actions').before(
					'<div class="ekwa-inline-error">Please fill in the required fields marked with *.</div>'
				);
			}
			return ok;
		},

		validateStep2: function () {
			var ok = true;
			$('#setup-step-2 .field-error').removeClass('field-error');
			$('.ekwa-inline-error').remove();

			$('.ekwa-location-card').each(function () {
				var $c = $(this);
				var idx = $c.data('idx');
				var required = ['phone', 'street_address', 'city', 'state', 'zip'];
				for (var r = 0; r < required.length; r++) {
					var $f = $c.find('input[data-loc="' + idx + '"][data-field="' + required[r] + '"]');
					if (!$f.val().trim()) {
						$f.addClass('field-error');
						ok = false;
					}
				}
			});

			if (!ok) {
				$('#setup-step-2 .ekwa-step-actions').before(
					'<div class="ekwa-inline-error">Each location needs at least a phone number and address.</div>'
				);
			}
			return ok;
		},

		validateStep4: function () {
			$('.ekwa-inline-error').remove();
			var h = $('#select_header').val();
			var f = $('#select_footer').val();
			if (!h || !f) {
				$('#setup-step-4 .ekwa-step-actions').before(
					'<div class="ekwa-inline-error">Please select both a header and a footer.</div>'
				);
				return false;
			}
			return true;
		},

		/* ==============================================================
		 * Save step via AJAX
		 * ============================================================*/

		saveStep: function (step) {
			// Validate
			if (step === 1 && !this.validateStep1()) return;
			if (step === 2 && !this.validateStep2()) return;
			if (step === 4 && !this.validateStep4()) return;

			var data;
			switch (step) {
				case 1: data = this.collectStep1(); break;
				case 2: data = this.collectStep2(); break;
				case 3: data = this.collectStep3(); break;
				case 4: data = this.collectStep4(); break;
			}

			this.showOverlay();
			var self = this;

			$.ajax({
				url:  ekwaSiteSetup.ajaxurl,
				type: 'POST',
				data: {
					action: 'ekwa_site_setup_save',
					nonce:  ekwaSiteSetup.nonce,
					step:   step,
					data:   data
				},
				success: function (resp) {
					self.hideOverlay();
					if (resp.success) {
						if (step === 4) {
							// Mark complete then go to final step
							$.post(ekwaSiteSetup.ajaxurl, {
								action: 'ekwa_site_setup_complete',
								nonce:  ekwaSiteSetup.nonce
							});
							self.goTo(5);
						} else {
							self.goTo(step + 1);
						}
					} else {
						alert(resp.data && resp.data.message ? resp.data.message : 'Error saving. Please try again.');
					}
				},
				error: function () {
					self.hideOverlay();
					alert('Network error. Please try again.');
				}
			});
		},

		/* ==============================================================
		 * Step navigation
		 * ============================================================*/

		goTo: function (n) {
			this.step = n;
			$('.ekwa-setup-step-content').hide();
			$('#setup-step-' + n).fadeIn(200);

			$('.ekwa-setup-step').removeClass('active completed');
			for (var i = 1; i < n; i++) {
				$('.ekwa-setup-step[data-step="' + i + '"]').addClass('completed');
			}
			$('.ekwa-setup-step[data-step="' + n + '"]').addClass('active');

			// Hide footer skip on last step
			$('.ekwa-setup-footer').toggle(n < 5);

			// Scroll to top of wizard
			$('.ekwa-setup-wrap')[0].scrollIntoView({ behavior: 'smooth' });
		},

		/* ==============================================================
		 * UI helpers
		 * ============================================================*/

		showOverlay: function () {
			if (!$('.ekwa-saving-overlay').length) {
				$('body').append('<div class="ekwa-saving-overlay"><span class="spinner is-active"></span></div>');
			}
		},

		hideOverlay: function () {
			$('.ekwa-saving-overlay').remove();
		},

		esc: function (str) {
			if (!str) return '';
			var div = document.createElement('div');
			div.appendChild(document.createTextNode(str));
			return div.innerHTML;
		}
	};

	$(function () {
		Setup.init();
	});

})(jQuery);
