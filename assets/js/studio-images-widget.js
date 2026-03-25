/**
 * Studio Images Widget - Frontend Handler
 * Handles: fade-up animation via IntersectionObserver
 * Widget: gm_studio_images
 * Vanilla JS only (no jQuery)
 */
(function () {
    'use strict';

    var StudioImagesHandler = function (scope) {
        var inner = scope.querySelector('.gm-studio-images__inner');
        if (!inner) return;

        // --- Fade-Up Animation ---
        if (inner.classList.contains('gm-studio-images__inner--hidden')) {
            var animDuration  = inner.getAttribute('data-animation-duration') || 600;
            var animDelay     = inner.getAttribute('data-animation-delay') || 0;
            var animDistance   = inner.getAttribute('data-animation-distance') || 20;
            var animThreshold = parseFloat(inner.getAttribute('data-animation-threshold')) || 0.15;

            // Override CSS custom properties for configurable animation
            inner.style.setProperty('--gm-si-anim-duration', animDuration + 'ms');
            inner.style.setProperty('--gm-si-anim-delay', animDelay + 'ms');
            inner.style.setProperty('--gm-si-anim-distance', animDistance + 'px');

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('gm-studio-images__inner--hidden');
                        entry.target.classList.add('gm-studio-images__inner--visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: animThreshold
            });

            observer.observe(inner);
        }
    };

    // Register with Elementor frontend
    window.addEventListener('DOMContentLoaded', function () {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/gm_studio_images.default',
                function ($scope) {
                    // $scope is a jQuery object from Elementor; get the raw DOM element
                    var scope = $scope[0] || $scope;
                    StudioImagesHandler(scope);
                }
            );
        }
    });
})();
