/**
 * Galerie Mueller - PullQuote Widget Frontend Script
 * Handles scroll-triggered fade-up animation via IntersectionObserver
 */
(function () {
	'use strict';

	function initPullQuoteAnimation() {
		var targets = document.querySelectorAll('.gm-pullquote__inner--hidden');

		if (!targets.length) {
			return;
		}

		if (!('IntersectionObserver' in window)) {
			targets.forEach(function (el) {
				el.classList.remove('gm-pullquote__inner--hidden');
				el.classList.add('gm-pullquote__inner--visible');
			});
			return;
		}

		targets.forEach(function (el) {
			var threshold = parseFloat(el.getAttribute('data-anim-threshold')) || 0.15;

			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							entry.target.classList.remove('gm-pullquote__inner--hidden');
							entry.target.classList.add('gm-pullquote__inner--visible');
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
		document.addEventListener('DOMContentLoaded', initPullQuoteAnimation);
	} else {
		initPullQuoteAnimation();
	}

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/gm_pullquote.default',
					function () {
						initPullQuoteAnimation();
					}
				);
			}
		});
	}
})();
