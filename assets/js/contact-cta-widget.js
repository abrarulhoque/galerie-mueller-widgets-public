/**
 * Galerie Mueller - Contact CTA Widget Frontend Script
 * Handles scroll-triggered fade-up animation via IntersectionObserver
 */
(function () {
	'use strict';

	function initContactCtaAnimation() {
		var targets = document.querySelectorAll('.gm-contact-cta__inner--hidden');

		if (!targets.length) {
			return;
		}

		if (!('IntersectionObserver' in window)) {
			targets.forEach(function (el) {
				el.classList.remove('gm-contact-cta__inner--hidden');
				el.classList.add('gm-contact-cta__inner--visible');
			});
			return;
		}

		targets.forEach(function (el) {
			var threshold = parseFloat(el.getAttribute('data-anim-threshold')) || 0.15;

			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							entry.target.classList.remove('gm-contact-cta__inner--hidden');
							entry.target.classList.add('gm-contact-cta__inner--visible');
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
		document.addEventListener('DOMContentLoaded', initContactCtaAnimation);
	} else {
		initContactCtaAnimation();
	}

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction(
					'frontend/element_ready/gm_contact_cta.default',
					function () {
						initContactCtaAnimation();
					}
				);
			}
		});
	}
})();
