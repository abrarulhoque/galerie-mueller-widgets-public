/**
 * Timeline Widget - Fade-Up Animation
 * Galerie Mueller
 *
 * Replaces React useFadeUp hook with vanilla IntersectionObserver.
 * Triggers once when element enters viewport.
 */
(function () {
    'use strict';

    function initTimelineAnimation() {
        var elements = document.querySelectorAll(
            '.gm-timeline__inner--hidden'
        );

        elements.forEach(function (el) {
            // Skip if already animated
            if (el.classList.contains('gm-timeline__inner--visible')) {
                return;
            }

            var duration  = parseInt(el.getAttribute('data-animation-duration'), 10) || 700;
            var offset    = parseInt(el.getAttribute('data-animation-offset'), 10) || 24;
            var threshold = parseFloat(el.getAttribute('data-animation-threshold')) || 0.15;

            // Set custom properties for the animation
            el.style.setProperty('--gm-timeline-duration', duration + 'ms');
            el.style.setProperty('--gm-timeline-offset', offset + 'px');

            var observer = new IntersectionObserver(
                function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove('gm-timeline__inner--hidden');
                            entry.target.classList.add('gm-timeline__inner--visible');
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
        document.addEventListener('DOMContentLoaded', initTimelineAnimation);
    } else {
        initTimelineAnimation();
    }

    // Re-init on Elementor frontend init (for editor preview)
    if (typeof jQuery !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/gm_timeline.default',
                function ($scope) {
                    initTimelineAnimation();
                }
            );
        });
    }
})();
