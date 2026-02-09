/*
 * Galerie Mueller - Artwork Grid Widget Frontend Script
 * Handles fade-up animation, click interactions, and image loading
 */
(function () {
  'use strict';

  // Initialize fade-up animation
  function initFadeUpAnimation() {
    var grids = document.querySelectorAll('.gm-artwork-grid__grid');

    grids.forEach(function (grid) {
      var items = grid.querySelectorAll('.gm-artwork-grid__item--hidden');
      if (!items.length) return;

      var threshold = parseFloat(grid.dataset.threshold) || 0.15;
      var animationDelay = parseInt(grid.dataset.delay, 10) || 100;

      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            var item = entry.target;
            var index = Array.from(items).indexOf(item);
            var delay = (index % 3) * animationDelay;

            setTimeout(function () {
              item.classList.remove('gm-artwork-grid__item--hidden');
              item.classList.add('gm-artwork-grid__item--visible');
            }, delay);

            observer.unobserve(item);
          }
        });
      }, { threshold: threshold });

      items.forEach(function (item) {
        observer.observe(item);
      });
    });
  }

  // Initialize click handlers
  function initClickHandlers() {
    var items = document.querySelectorAll('.gm-artwork-grid__item[data-click-action]');

    items.forEach(function (item) {
      var action = item.dataset.clickAction;
      var link = item.dataset.artworkLink;
      var triggerId = item.dataset.triggerSelector;

      if (action === 'none') return;

      item.addEventListener('click', function (e) {
        e.preventDefault();

        if (action === 'lightbox') {
          // Trigger lightbox
          if (triggerId) {
            var trigger = document.querySelector(triggerId);
            if (trigger) trigger.click();
          }

          // Dispatch custom lightbox event
          var imageEl = item.querySelector('.gm-artwork-grid__image');
          var titleEl = item.querySelector('.gm-artwork-grid__title');
          var mediumEl = item.querySelector('.gm-artwork-grid__medium');

          var event = new CustomEvent('artworkLightbox', {
            detail: {
              image: imageEl ? imageEl.src : '',
              title: titleEl ? titleEl.textContent : '',
              medium: mediumEl ? mediumEl.textContent : '',
              index: Array.from(items).indexOf(item)
            }
          });
          document.dispatchEvent(event);

        } else if (action === 'link' && link) {
          try {
            var linkData = JSON.parse(link);
            if (linkData.is_external) {
              window.open(linkData.url, '_blank');
            } else {
              window.location.href = linkData.url;
            }
          } catch (err) {
            console.error('Error parsing artwork link:', err);
          }
        }
      });
    });
  }

  // Initialize image loading states
  function initImageLoading() {
    var images = document.querySelectorAll('.gm-artwork-grid__image');

    images.forEach(function (img) {
      if (img.classList.contains('gm-artwork-grid__image--loaded')) return;

      img.classList.add('gm-artwork-grid__image--loading');

      if (img.complete) {
        img.classList.remove('gm-artwork-grid__image--loading');
        img.classList.add('gm-artwork-grid__image--loaded');
      } else {
        img.addEventListener('load', function () {
          img.classList.remove('gm-artwork-grid__image--loading');
          img.classList.add('gm-artwork-grid__image--loaded');
        });
        img.addEventListener('error', function () {
          img.classList.remove('gm-artwork-grid__image--loading');
        });
      }
    });
  }

  // Main initialization
  function initArtworkGrid() {
    initFadeUpAnimation();
    initClickHandlers();
    initImageLoading();
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initArtworkGrid);
  } else {
    initArtworkGrid();
  }

  // Re-initialize when Elementor frontend loads (for live preview)
  if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
      if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction(
          'frontend/element_ready/gm_artwork_grid.default',
          function ($scope) {
            initArtworkGrid();
          }
        );
      }
    });
  }

  // Listen for category tab changes to potentially filter/animate grid
  document.addEventListener('categoryTabChanged', function (e) {
    // Re-initialize animations after category change if needed
    setTimeout(function () {
      initFadeUpAnimation();
      initImageLoading();
    }, 100);
  });

  // Expose for external use
  window.GMArtworkGrid = {
    init: initArtworkGrid,
    initFadeUp: initFadeUpAnimation,
    initImages: initImageLoading
  };
})();
