/**
 * Galerie Mueller - Categories Widget Frontend Script
 * Handles scroll-triggered fade-up animation via IntersectionObserver
 */
(function () {
	'use strict';

	function initCategoriesAnimation() {
		var targets = document.querySelectorAll('.gm-categories__container--hidden');

		if (!targets.length) {
			return;
		}

		if (!('IntersectionObserver' in window)) {
			targets.forEach(function (el) {
				el.classList.remove('gm-categories__container--hidden');
				el.classList.add('gm-categories__container--visible');
			});
			return;
		}

		targets.forEach(function (el) {
			var threshold = parseFloat(el.getAttribute('data-anim-threshold')) || 0.15;

			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							entry.target.classList.remove('gm-categories__container--hidden');
							entry.target.classList.add('gm-categories__container--visible');
							observer.unobserve(entry.target);
						}
					});
				},
				{ threshold: threshold }
			);

			observer.observe(el);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initCategoriesAnimation);
	} else {
		initCategoriesAnimation();
	}

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/gm_categories.default',
					function () {
						initCategoriesAnimation();
					}
				);
			}
		});
	}
})();
