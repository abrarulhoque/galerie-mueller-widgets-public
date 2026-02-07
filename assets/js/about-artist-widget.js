/**
 * Galerie Mueller - About Artist Widget Frontend Script
 * Handles scroll-triggered fade-up animation via IntersectionObserver
 */
(function () {
	'use strict';

	function initAboutArtistAnimation() {
		var targets = document.querySelectorAll('.gm-about-grid--hidden');

		if (!targets.length) {
			return;
		}

		if (!('IntersectionObserver' in window)) {
			targets.forEach(function (el) {
				el.classList.remove('gm-about-grid--hidden');
				el.classList.add('gm-about-grid--visible');
			});
			return;
		}

		targets.forEach(function (el) {
			var threshold = parseFloat(el.getAttribute('data-anim-threshold')) || 0.15;

			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							entry.target.classList.remove('gm-about-grid--hidden');
							entry.target.classList.add('gm-about-grid--visible');
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
		document.addEventListener('DOMContentLoaded', initAboutArtistAnimation);
	} else {
		initAboutArtistAnimation();
	}

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/gm_about_artist.default',
					function () {
						initAboutArtistAnimation();
					}
				);
			}
		});
	}
})();
