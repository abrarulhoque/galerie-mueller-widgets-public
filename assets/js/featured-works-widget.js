/**
 * Galerie Mueller - Featured Works Widget Frontend Script
 * Handles scroll-triggered fade-up animation via IntersectionObserver
 */
(function () {
	'use strict';

	function initFeaturedWorksAnimation() {
		var targets = document.querySelectorAll('.gm-fw-inner--hidden');

		if (!targets.length) {
			return;
		}

		// Fallback for browsers without IntersectionObserver
		if (!('IntersectionObserver' in window)) {
			targets.forEach(function (el) {
				el.classList.remove('gm-fw-inner--hidden');
				el.classList.add('gm-fw-inner--visible');
			});
			return;
		}

		targets.forEach(function (el) {
			var threshold = parseFloat(el.getAttribute('data-anim-threshold')) || 0.15;

			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							entry.target.classList.remove('gm-fw-inner--hidden');
							entry.target.classList.add('gm-fw-inner--visible');
							observer.unobserve(entry.target);
						}
					});
				},
				{ threshold: threshold }
			);

			observer.observe(el);
		});
	}

	// Run on DOMContentLoaded
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initFeaturedWorksAnimation);
	} else {
		initFeaturedWorksAnimation();
	}

	// Re-init when Elementor frontend initializes (for editor preview)
	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/gm_featured_works.default',
					function () {
						initFeaturedWorksAnimation();
					}
				);
			}
		});
	}
})();
