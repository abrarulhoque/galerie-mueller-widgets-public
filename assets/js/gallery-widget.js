/**
 * Gallery Widget (gm_gallery) -- Frontend JavaScript
 *
 * Handles:
 * 1. Tab filtering (show/hide cards)
 * 2. Grid card click -> open lightbox
 * 3. Lightbox prev/next navigation within filtered set
 * 4. Keyboard navigation (Escape, ArrowLeft, ArrowRight)
 * 5. Click outside modal -> close
 * 6. Body scroll lock when lightbox open
 * 7. Fade-up entrance animation with stagger delays
 * 8. Elementor editor re-initialization
 */
(function () {
    'use strict';

    /**
     * Main initializer for a single gallery widget instance.
     * @param {HTMLElement} widgetEl - The .gm-gallery root element.
     */
    function initGalleryWidget(widgetEl) {
        // Prevent double init
        if (widgetEl.dataset.gmGalleryInit === 'true') {
            return;
        }
        widgetEl.dataset.gmGalleryInit = 'true';

        // ---- Cache DOM references ----
        var tabs        = widgetEl.querySelectorAll('.gm-gallery__tab');
        var cards       = widgetEl.querySelectorAll('.gm-gallery__card');
        var grid        = widgetEl.querySelector('.gm-gallery__grid');
        var emptyMsg    = widgetEl.querySelector('.gm-gallery__empty');
        var lightbox    = widgetEl.querySelector('.gm-gallery__lightbox');
        var lbOverlay   = widgetEl.querySelector('.gm-gallery__lightbox-overlay');
        var lbClose     = widgetEl.querySelector('.gm-gallery__lightbox-close');
        var lbModal     = widgetEl.querySelector('.gm-gallery__lightbox-modal');
        var lbImage     = widgetEl.querySelector('.gm-gallery__lightbox-image');
        var lbTitle     = widgetEl.querySelector('.gm-gallery__lightbox-title');
        var lbMedium    = widgetEl.querySelector('.gm-gallery__lightbox-medium');
        var lbYear      = widgetEl.querySelector('.gm-gallery__lightbox-year');
        var lbDimensions = widgetEl.querySelector('.gm-gallery__lightbox-dimensions');
        var lbCta       = widgetEl.querySelector('.gm-gallery__lightbox-cta');
        var lbPrev      = widgetEl.querySelector('.gm-gallery__lightbox-prev');
        var lbNext      = widgetEl.querySelector('.gm-gallery__lightbox-next');

        // ---- Read settings from data attributes ----
        var settings = {
            lightboxEnabled:     widgetEl.dataset.lightbox === 'yes',
            enableUrlParams:     widgetEl.dataset.urlParams === 'yes',
            keyboardNav:         widgetEl.dataset.keyboardNav === 'yes',
            clickOutsideClose:   widgetEl.dataset.clickOutsideClose === 'yes',
            fadeUpEnabled:       widgetEl.dataset.fadeUp === 'yes',
            animationDuration:   parseInt(widgetEl.dataset.animDuration, 10) || 600,
            animationDistance:   parseInt(widgetEl.dataset.animDistance, 10) || 20,
            staggerDelay:        parseInt(widgetEl.dataset.staggerDelay, 10) || 100,
            animationThreshold:  parseFloat(widgetEl.dataset.animThreshold) || 0.15,
            ctaBaseUrl:          widgetEl.dataset.ctaUrl || '/kontakt',
            gridColumns:         parseInt(widgetEl.dataset.gridColumns, 10) || 3
        };

        // ---- State ----
        var activeFilter  = '';       // '' = all
        var currentIndex  = -1;       // index within visibleCards
        var isLightboxOpen = false;

        // ---- Helpers ----

        /**
         * Get array of currently visible (not hidden) cards.
         */
        function getVisibleCards() {
            var result = [];
            for (var i = 0; i < cards.length; i++) {
                if (!cards[i].classList.contains('gm-gallery__card--hidden')) {
                    result.push(cards[i]);
                }
            }
            return result;
        }

        /**
         * Get the number of grid columns at the current viewport.
         */
        function getCurrentColumns() {
            if (!grid) return 1;
            var style = window.getComputedStyle(grid);
            var cols = style.getPropertyValue('grid-template-columns').split(' ').length;
            return cols || 1;
        }

        // ---- 1. Tab Filtering ----

        function setActiveTab(filterValue) {
            activeFilter = filterValue;

            // Update tab active states
            for (var t = 0; t < tabs.length; t++) {
                var tab = tabs[t];
                if (tab.dataset.filter === filterValue) {
                    tab.classList.add('gm-gallery__tab--active');
                } else {
                    tab.classList.remove('gm-gallery__tab--active');
                }
            }

            // Show/hide cards
            var visibleCount = 0;
            for (var c = 0; c < cards.length; c++) {
                var card = cards[c];
                var category = card.dataset.category || '';
                var shouldShow = (filterValue === '' || category === filterValue);

                if (shouldShow) {
                    card.classList.remove('gm-gallery__card--hidden');
                    visibleCount++;
                } else {
                    card.classList.add('gm-gallery__card--hidden');
                }
            }

            // Empty message
            if (emptyMsg) {
                if (visibleCount === 0) {
                    emptyMsg.classList.add('gm-gallery__empty--visible');
                } else {
                    emptyMsg.classList.remove('gm-gallery__empty--visible');
                }
            }

            // Re-trigger fade-up on visible cards
            if (settings.fadeUpEnabled) {
                triggerFadeUpOnVisibleCards();
            }
        }

        function handleTabClick(e) {
            e.preventDefault();
            var filterValue = e.currentTarget.dataset.filter;
            if (filterValue === undefined) filterValue = '';
            setActiveTab(filterValue);
        }

        // Bind tab click events
        for (var t = 0; t < tabs.length; t++) {
            tabs[t].addEventListener('click', handleTabClick);
        }

        // ---- 7. Fade-Up Animation ----

        var fadeObserver = null;

        function triggerFadeUpOnVisibleCards() {
            var visible = getVisibleCards();
            var cols = getCurrentColumns();

            for (var i = 0; i < visible.length; i++) {
                var inner = visible[i].querySelector('.gm-gallery__card-inner');
                if (!inner) continue;

                // Reset animation
                inner.classList.remove('gm-gallery__card-inner--animate-visible');
                inner.classList.add('gm-gallery__card-inner--animate-init');

                // Set stagger delay based on column position
                var stagger = (i % cols) * settings.staggerDelay;
                inner.style.animationDelay = stagger + 'ms';
                inner.style.animationDuration = settings.animationDuration + 'ms';
            }

            // Observe with IntersectionObserver
            if (fadeObserver) {
                fadeObserver.disconnect();
            }

            fadeObserver = new IntersectionObserver(function (entries) {
                for (var e = 0; e < entries.length; e++) {
                    if (entries[e].isIntersecting) {
                        var target = entries[e].target;
                        var cardInner = target.querySelector('.gm-gallery__card-inner');
                        if (cardInner) {
                            cardInner.classList.remove('gm-gallery__card-inner--animate-init');
                            cardInner.classList.add('gm-gallery__card-inner--animate-visible');
                        }
                        fadeObserver.unobserve(target);
                    }
                }
            }, {
                threshold: settings.animationThreshold
            });

            for (var j = 0; j < visible.length; j++) {
                fadeObserver.observe(visible[j]);
            }
        }

        // Set CSS custom property for animation distance
        widgetEl.style.setProperty('--gm-gallery-fade-distance', settings.animationDistance + 'px');

        // Initial fade-up setup
        if (settings.fadeUpEnabled) {
            triggerFadeUpOnVisibleCards();
        }

        // ---- 2. Grid Card Click -> Open Lightbox ----

        function handleCardClick(e) {
            if (!settings.lightboxEnabled || !lightbox) return;

            // Find the card element (might have clicked on child)
            var cardEl = e.currentTarget;
            var visibleCards = getVisibleCards();
            var idx = visibleCards.indexOf(cardEl);
            if (idx === -1) return;

            openLightbox(idx, visibleCards);
        }

        // Bind click events on all cards
        for (var c = 0; c < cards.length; c++) {
            cards[c].addEventListener('click', handleCardClick);
        }

        // ---- 3. Lightbox Open / Close / Navigate ----

        function openLightbox(index, visibleCards) {
            if (!lightbox) return;

            currentIndex = index;
            populateLightbox(visibleCards[index]);
            updateNavButtons(visibleCards);

            lightbox.classList.add('gm-gallery__lightbox--open');
            lightbox.setAttribute('aria-hidden', 'false');
            isLightboxOpen = true;

            // Body scroll lock
            document.body.style.overflow = 'hidden';

            // Bind keyboard events
            if (settings.keyboardNav) {
                document.addEventListener('keydown', handleKeyDown);
            }
        }

        function closeLightbox() {
            if (!lightbox) return;

            lightbox.classList.remove('gm-gallery__lightbox--open');
            lightbox.setAttribute('aria-hidden', 'true');
            isLightboxOpen = false;
            currentIndex = -1;

            // Restore body scroll
            document.body.style.overflow = '';

            // Unbind keyboard events
            document.removeEventListener('keydown', handleKeyDown);
        }

        function populateLightbox(cardEl) {
            if (!cardEl) return;

            var title      = cardEl.dataset.title || '';
            var medium     = cardEl.dataset.medium || '';
            var year       = cardEl.dataset.year || '';
            var dimensions = cardEl.dataset.dimensions || '';
            var imageSrc   = cardEl.dataset.image || '';

            if (lbImage) {
                lbImage.src = imageSrc;
                lbImage.alt = title;
            }
            if (lbTitle) {
                lbTitle.textContent = title;
            }
            if (lbMedium) {
                lbMedium.textContent = medium;
            }
            if (lbYear) {
                lbYear.textContent = year;
            }
            if (lbDimensions) {
                lbDimensions.textContent = dimensions;
                lbDimensions.style.display = dimensions ? '' : 'none';
            }
            if (lbCta && settings.enableUrlParams) {
                var baseUrl = settings.ctaBaseUrl;
                var separator = baseUrl.indexOf('?') !== -1 ? '&' : '?';
                lbCta.href = baseUrl + separator + 'werk=' + encodeURIComponent(title);
            }
        }

        function updateNavButtons(visibleCards) {
            if (!lbPrev || !lbNext) return;

            lbPrev.disabled = (currentIndex <= 0);
            lbNext.disabled = (currentIndex >= visibleCards.length - 1);
        }

        function navigateLightbox(direction) {
            var visibleCards = getVisibleCards();
            var newIndex = currentIndex + direction;

            if (newIndex < 0 || newIndex >= visibleCards.length) return;

            currentIndex = newIndex;
            populateLightbox(visibleCards[currentIndex]);
            updateNavButtons(visibleCards);
        }

        // ---- 4. Keyboard Navigation ----

        function handleKeyDown(e) {
            if (!isLightboxOpen) return;

            switch (e.key) {
                case 'Escape':
                    e.preventDefault();
                    closeLightbox();
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    navigateLightbox(-1);
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    navigateLightbox(1);
                    break;
            }
        }

        // ---- 5. Click Outside Modal -> Close ----

        if (lbOverlay && settings.clickOutsideClose) {
            lbOverlay.addEventListener('click', function (e) {
                // Only close if clicked directly on overlay, not on modal children
                if (e.target === lbOverlay) {
                    closeLightbox();
                }
            });
        }

        // Close button
        if (lbClose) {
            lbClose.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeLightbox();
            });
        }

        // Prevent clicks inside modal from bubbling to overlay
        if (lbModal) {
            lbModal.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }

        // Prev / Next buttons
        if (lbPrev) {
            lbPrev.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                navigateLightbox(-1);
            });
        }

        if (lbNext) {
            lbNext.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                navigateLightbox(1);
            });
        }

        // ---- 6. Body Scroll Lock ----
        // (Handled inside openLightbox / closeLightbox above)

    } // end initGalleryWidget

    // ---- 8. Initialization ----

    /**
     * Initialize all gallery widgets on the page.
     */
    function initAll() {
        var widgets = document.querySelectorAll('.gm-gallery');
        for (var i = 0; i < widgets.length; i++) {
            initGalleryWidget(widgets[i]);
        }
    }

    // Standard page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    // Elementor editor: re-initialize when widget is rendered in preview
    if (typeof jQuery !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', function () {
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/gm_gallery.default',
                    function ($scope) {
                        var el = $scope[0];
                        if (el) {
                            // Reset init flag so it can re-init
                            var gallery = el.querySelector('.gm-gallery');
                            if (gallery) {
                                gallery.dataset.gmGalleryInit = 'false';
                                initGalleryWidget(gallery);
                            }
                        }
                    }
                );
            }
        });
    }

})();
