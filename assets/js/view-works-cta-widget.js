(function () {
    "use strict";

    function initViewWorksCTAAnimation() {
        var elements = document.querySelectorAll(
            '.gm-view-works-cta__inner[data-animation="true"]'
        );

        elements.forEach(function (el) {
            // Skip if already animated
            if (el.classList.contains('gm-view-works-cta__inner--animated')) {
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
                            el.classList.remove('gm-view-works-cta__inner--hidden');
                            el.classList.add('gm-view-works-cta__inner--animated');
                            observer.unobserve(el);
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
        document.addEventListener('DOMContentLoaded', initViewWorksCTAAnimation);
    } else {
        initViewWorksCTAAnimation();
    }

    // Re-init on Elementor frontend init (for editor preview)
    if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/gm_view_works_cta.default',
            function ($scope) {
                initViewWorksCTAAnimation();
            }
        );
    });
    }
})();
