/**
 * Galerie Mueller - Header Widget Frontend Script
 * Handles scroll state detection and mobile menu toggling
 */
(function () {
	'use strict';

	function initHeaderWidget() {
		var headers = document.querySelectorAll('.gm-header');

		if (!headers.length) {
			return;
		}

		headers.forEach(function (header) {
			var scrollThreshold = parseInt(header.getAttribute('data-scroll-threshold'), 10) || 40;
			var hamburger = header.querySelector('.gm-header__hamburger');
			var overlay = header.querySelector('.gm-header__mobile-overlay');

			// Scroll detection
			function onScroll() {
				if (window.scrollY > scrollThreshold) {
					header.classList.add('is-scrolled');
				} else {
					header.classList.remove('is-scrolled');
				}
			}

			window.addEventListener('scroll', onScroll, { passive: true });
			onScroll(); // Initial check

			// Mobile menu toggle
			if (hamburger && overlay) {
				hamburger.addEventListener('click', function () {
					var isOpen = hamburger.classList.toggle('is-open');
					overlay.classList.toggle('is-open', isOpen);
					document.body.classList.toggle('gm-menu-open', isOpen);
				});

				// Close menu when clicking a link
				var mobileLinks = overlay.querySelectorAll('.gm-header__mobile-link');
				mobileLinks.forEach(function (link) {
					link.addEventListener('click', function () {
						hamburger.classList.remove('is-open');
						overlay.classList.remove('is-open');
						document.body.classList.remove('gm-menu-open');
					});
				});
			}
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initHeaderWidget);
	} else {
		initHeaderWidget();
	}

	// Elementor frontend hook
	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/gm_header.default',
					function () {
						initHeaderWidget();
					}
				);
			}
		});
	}
})();
