/**
 * Timeline Widget - Fade-Up Animation
 * Galerie Mueller
 *
 * Replaces React useFadeUp hook with vanilla IntersectionObserver.
 * Triggers once when element enters viewport.
 */
(function($) {
    'use strict';

    var TimelineHandler = function($scope, $) {
        var $inner = $scope.find('.gm-timeline__inner--hidden');
        if (!$inner.length) return;

        // Read animation settings from data attributes
        var duration  = parseInt($inner.data('animation-duration'), 10) || 700;
        var offset    = parseInt($inner.data('animation-offset'), 10) || 24;
        var threshold = parseFloat($inner.data('animation-threshold')) || 0.15;

        // Build dynamic keyframes
        var animationName = 'gm-timeline-fade-up-' + $scope.data('id');
        var styleId = 'gm-timeline-style-' + $scope.data('id');

        // Remove any previously injected style (for Elementor editor re-renders)
        $('#' + styleId).remove();

        var keyframes =
            '@keyframes ' + animationName + ' {' +
                'from { opacity: 0; transform: translateY(' + offset + 'px); }' +
                'to { opacity: 1; transform: translateY(0); }' +
            '}';

        $('<style>')
            .attr('id', styleId)
            .text(keyframes)
            .appendTo('head');

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    el.style.animation = animationName + ' ' + duration + 'ms ease-out forwards';
                    el.classList.remove('gm-timeline__inner--hidden');
                    el.classList.add('gm-timeline__inner--visible');
                    observer.unobserve(el);
                }
            });
        }, {
            threshold: threshold
        });

        observer.observe($inner[0]);
    };

    // Register handler with Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/gm_timeline.default',
            TimelineHandler
        );
    });

})(jQuery);
