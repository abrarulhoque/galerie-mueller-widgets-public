(function () {
    "use strict";

    function initBiographyAnimation() {
        var elements = document.querySelectorAll(
            '.gm-biography__inner[data-animation="true"]'
        );

        elements.forEach(function (el) {
            // Skip if already animated
            if (el.classList.contains('gm-biography__inner--animated')) {
                return;
            }

            var threshold = parseFloat(el.dataset.threshold) || 0.15;
            var duration  = el.dataset.duration || '600ms';
            var offset    = el.dataset.offset || '20px';

            // Set custom properties for the animation
            el.style.setProperty('--gm-fade-duration', duration);
            el.style.setProperty('--gm-fade-offset', offset);

            var observer = new IntersectionObserver(
                function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            el.classList.remove('gm-biography__inner--hidden');
                            el.classList.add('gm-biography__inner--animated');
                            observer.unobserve(el);
                        }
                    });
                },
                { threshold: threshold }
            );

            observer.observe(el);
        });
    }

    // Run on DOMContentLoaded and on Elementor frontend init
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBiographyAnimation);
    } else {
        initBiographyAnimation();
    }

    // Re-init on Elementor frontend init (for editor preview)
    if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/gm_biography.default',
            function ($scope) {
                initBiographyAnimation();
            }
        );
    });
    }
})();
