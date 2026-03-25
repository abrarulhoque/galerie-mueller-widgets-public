/**
 * Studio Images Widget - Frontend Handler
 * Handles: fade-up animation via IntersectionObserver
 * Widget: gm_studio_images
 * Vanilla JS only (no jQuery)
 */
(function () {
    'use strict';

    function initStudioImagesAnimation() {
        var elements = document.querySelectorAll(
            '.gm-studio-images__inner.gm-studio-images__inner--hidden'
        );

        elements.forEach(function (el) {
            // Skip if already animated
            if (el.classList.contains('gm-studio-images__inner--visible')) {
                return;
            }

            var duration  = el.getAttribute('data-animation-duration') || 600;
            var delay     = el.getAttribute('data-animation-delay') || 0;
            var distance  = el.getAttribute('data-animation-distance') || 20;
            var threshold = parseFloat(el.getAttribute('data-animation-threshold')) || 0.15;

            // Override CSS custom properties for configurable animation
            el.style.setProperty('--gm-si-anim-duration', duration + 'ms');
            el.style.setProperty('--gm-si-anim-delay', delay + 'ms');
            el.style.setProperty('--gm-si-anim-distance', distance + 'px');

            var observer = new IntersectionObserver(
                function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove('gm-studio-images__inner--hidden');
                            entry.target.classList.add('gm-studio-images__inner--visible');
                            observer.unobserve(entry.target);
                        }
                    });
                },
                { threshold: threshold }
            );

            observer.observe(el);
        });
    }

    // Run on DOMContentLoaded or immediately if already loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStudioImagesAnimation);
    } else {
        initStudioImagesAnimation();
    }

    // Re-init on Elementor frontend init (for editor preview)
    if (typeof jQuery !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/gm_studio_images.default',
                function ($scope) {
                    initStudioImagesAnimation();
                }
            );
        });
    }
})();
