/**
 * EKWA Plugin Wizard JavaScript
 */

(function($) {
	'use strict';

	var EkwaWizard = {
		currentStep: 1,
		totalPlugins: 0,
		installedPlugins: 0,

		init: function() {
			this.bindEvents();
		},

		bindEvents: function() {
			$('#install-required').on('click', this.installRequiredPlugins.bind(this));
			$('#install-optional').on('click', this.installOptionalPlugins.bind(this));
			$('#skip-optional').on('click', this.skipOptional.bind(this));
			$('#skip-wizard').on('click', this.skipWizard.bind(this));
		},

		installRequiredPlugins: function(e) {
			e.preventDefault();

			var plugins = [];
			$('#step-1 .ekwa-plugin-item').each(function() {
				var status = $(this).hasClass('status-active') ? 'active' :
				            $(this).hasClass('status-inactive') ? 'inactive' : 'not-installed';

				if (status !== 'active') {
					plugins.push({
						slug: $(this).data('slug'),
						type: $(this).data('type'),
						element: $(this)
					});
				}
			});

			if (plugins.length === 0) {
				this.nextStep();
				return;
			}

			this.totalPlugins = plugins.length;
			this.installedPlugins = 0;

			$('#install-required').prop('disabled', true).text(ekwaWizard.installing);

			this.installPluginsSequentially(plugins, function() {
				$('#install-required').prop('disabled', false);
				EkwaWizard.nextStep();
			});
		},

		installOptionalPlugins: function(e) {
			e.preventDefault();

			var plugins = [];
			$('#step-2 .ekwa-plugin-item').each(function() {
				var $checkbox = $(this).find('input[type="checkbox"]');
				if ($checkbox.length && $checkbox.is(':checked') && !$checkbox.is(':disabled')) {
					var status = $(this).hasClass('status-active') ? 'active' :
					            $(this).hasClass('status-inactive') ? 'inactive' : 'not-installed';

					if (status !== 'active') {
						plugins.push({
							slug: $(this).data('slug'),
							type: $(this).data('type'),
							element: $(this)
						});
					}
				}
			});

			if (plugins.length === 0) {
				this.completeWizard();
				return;
			}

			this.totalPlugins = plugins.length;
			this.installedPlugins = 0;

			$('#install-optional').prop('disabled', true).text(ekwaWizard.installing);

			this.installPluginsSequentially(plugins, function() {
				$('#install-optional').prop('disabled', false);
				EkwaWizard.completeWizard();
			});
		},

		installPluginsSequentially: function(plugins, callback) {
			if (plugins.length === 0) {
				if (callback) callback();
				return;
			}

			var plugin = plugins.shift();
			var self = this;

			this.installPlugin(plugin, function(success) {
				self.installedPlugins++;

				if (success) {
					self.activatePlugin(plugin, function() {
						self.installPluginsSequentially(plugins, callback);
					});
				} else {
					self.installPluginsSequentially(plugins, callback);
				}
			});
		},

		installPlugin: function(plugin, callback) {
			var $item = plugin.element;
			var action = plugin.type === 'bundled' ? 'ekwa_install_bundled_plugin' : 'ekwa_install_wp_plugin';

			// Check if already installed
			if ($item.hasClass('status-inactive') || $item.hasClass('status-active')) {
				if (callback) callback(true);
				return;
			}

			$item.addClass('installing');
			$item.find('.status-text').text(ekwaWizard.installing);

			$.ajax({
				url: ekwaWizard.ajaxurl,
				type: 'POST',
				data: {
					action: action,
					nonce: ekwaWizard.nonce,
					slug: plugin.slug
				},
				success: function(response) {
					$item.removeClass('installing');

					if (response.success) {
						$item.removeClass('status-not-installed').addClass('status-inactive');
						$item.find('.status-text').text('Installed');
						if (callback) callback(true);
					} else {
						$item.find('.status-text').html('<span style="color: #d63638;">' + ekwaWizard.error + '</span>');
						EkwaWizard.showError($item, response.data.message || ekwaWizard.plugin_error);
						if (callback) callback(false);
					}
				},
				error: function() {
					$item.removeClass('installing');
					$item.find('.status-text').html('<span style="color: #d63638;">' + ekwaWizard.error + '</span>');
					EkwaWizard.showError($item, ekwaWizard.plugin_error);
					if (callback) callback(false);
				}
			});
		},

		activatePlugin: function(plugin, callback) {
			var $item = plugin.element;

			// Check if already active
			if ($item.hasClass('status-active')) {
				if (callback) callback(true);
				return;
			}

			$item.addClass('activating');
			$item.find('.status-text').text(ekwaWizard.activating);

			$.ajax({
				url: ekwaWizard.ajaxurl,
				type: 'POST',
				data: {
					action: 'ekwa_activate_plugin',
					nonce: ekwaWizard.nonce,
					slug: plugin.slug
				},
				success: function(response) {
					$item.removeClass('activating');

					if (response.success) {
						$item.removeClass('status-inactive').addClass('status-active');
						$item.find('.status-text').html('<span style="color: #46b450;">' + ekwaWizard.success + '</span>');
						$item.find('input[type="checkbox"]').prop('disabled', true);
						if (callback) callback(true);
					} else {
						$item.find('.status-text').html('<span style="color: #f0b849;">Installed (Activation Failed)</span>');
						EkwaWizard.showError($item, response.data.message || 'Activation failed');
						if (callback) callback(false);
					}
				},
				error: function() {
					$item.removeClass('activating');
					$item.find('.status-text').html('<span style="color: #f0b849;">Installed (Activation Failed)</span>');
					EkwaWizard.showError($item, 'Activation failed');
					if (callback) callback(false);
				}
			});
		},

		showError: function($item, message) {
			var $error = $('<div class="ekwa-error-message">' + message + '</div>');
			$item.after($error);
			setTimeout(function() {
				$error.fadeOut(function() {
					$(this).remove();
				});
			}, 5000);
		},

		nextStep: function() {
			this.currentStep++;
			this.updateSteps();
		},

		updateSteps: function() {
			$('.ekwa-wizard-step-content').hide();
			$('#step-' + this.currentStep).fadeIn();

			$('.ekwa-step').removeClass('active completed');
			$('.ekwa-step[data-step="' + this.currentStep + '"]').addClass('active');

			for (var i = 1; i < this.currentStep; i++) {
				$('.ekwa-step[data-step="' + i + '"]').addClass('completed');
			}

			// Hide skip wizard link on last step
			if (this.currentStep === 3) {
				$('.ekwa-wizard-footer').hide();
			}
		},

		skipOptional: function(e) {
			e.preventDefault();
			this.completeWizard();
		},

		completeWizard: function() {
			this.currentStep = 3;
			this.updateSteps();

			// Mark wizard as completed
			$.ajax({
				url: ekwaWizard.ajaxurl,
				type: 'POST',
				data: {
					action: 'ekwa_skip_wizard',
					nonce: ekwaWizard.nonce
				}
			});

			// Update option to mark wizard completed
			$.ajax({
				url: ekwaWizard.ajaxurl,
				type: 'POST',
				data: {
					action: 'ekwa_complete_wizard',
					nonce: ekwaWizard.nonce
				}
			});
		},

		skipWizard: function(e) {
			e.preventDefault();

			if (!confirm('Are you sure you want to skip the setup wizard? You can run it later from Appearance > Plugin Setup.')) {
				return;
			}

			$.ajax({
				url: ekwaWizard.ajaxurl,
				type: 'POST',
				data: {
					action: 'ekwa_skip_wizard',
					nonce: ekwaWizard.nonce
				},
				success: function() {
					window.location.href = ekwaWizard.adminUrl || '/wp-admin/';
				}
			});
		}
	};

	// Initialize on document ready
	$(document).ready(function() {
		if ($('.ekwa-wizard-wrap').length) {
			EkwaWizard.init();
		}
	});

	// Add complete wizard AJAX handler
	$(document).ready(function() {
		window.EkwaWizard = EkwaWizard;
	});

	// Add action for completing wizard
	wp = window.wp || {};
	if (typeof wp.ajax !== 'undefined') {
		wp.ajax.post('ekwa_complete_wizard', {
			nonce: ekwaWizard.nonce
		});
	}

})(jQuery);

// Add AJAX action for completing wizard
jQuery(document).ready(function($) {
	$(document).on('click', '.ekwa-wizard-complete a', function() {
		$.ajax({
			url: ekwaWizard.ajaxurl,
			type: 'POST',
			data: {
				action: 'ekwa_complete_wizard',
				nonce: ekwaWizard.nonce
			}
		});
	});
});
