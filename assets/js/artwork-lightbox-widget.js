/*
 * Galerie Mueller - Artwork Lightbox Widget Frontend Script
 * Handles modal functionality, navigation, and keyboard controls
 */
(function () {
  'use strict';

  var GMArtworkLightbox = {
    $lightbox: null,
    settings: {},
    currentArtwork: null,
    artworkList: [],
    currentIndex: -1,
    previousFocus: null,

    /**
     * Initialize lightbox
     */
    init: function () {
      var self = this;
      self.$lightbox = document.querySelector('.gm-lightbox__overlay');

      if (!self.$lightbox) return;

      // Get settings from data attribute
      var settingsAttr = self.$lightbox.getAttribute('data-settings');
      self.settings = settingsAttr ? JSON.parse(settingsAttr) : {};

      self.bindEvents();
      self.setupKeyboardHandlers();
    },

    /**
     * Bind event handlers
     */
    bindEvents: function () {
      var self = this;
      var $closeBtn = self.$lightbox.querySelector('.gm-lightbox__close');
      var $prevBtn = self.$lightbox.querySelector('.gm-lightbox__nav-button--prev');
      var $nextBtn = self.$lightbox.querySelector('.gm-lightbox__nav-button--next');
      var $content = self.$lightbox.querySelector('.gm-lightbox__content');

      // Close button
      if ($closeBtn) {
        $closeBtn.addEventListener('click', function () {
          self.close();
        });
      }

      // Click outside to close
      if (self.settings.enable_click_outside !== 'no') {
        self.$lightbox.addEventListener('click', function (e) {
          if (e.target === self.$lightbox) {
            self.close();
          }
        });
      }

      // Prevent event bubbling on content click
      if ($content) {
        $content.addEventListener('click', function (e) {
          e.stopPropagation();
        });
      }

      // Navigation buttons
      if ($prevBtn) {
        $prevBtn.addEventListener('click', function () {
          self.showPrevious();
        });
      }

      if ($nextBtn) {
        $nextBtn.addEventListener('click', function () {
          self.showNext();
        });
      }

      // Listen for custom open event from artwork grid
      document.addEventListener('artworkLightbox', function (e) {
        if (e.detail) {
          self.openFromEvent(e.detail);
        }
      });

      // Listen for jQuery-based open event (if jQuery available)
      if (typeof jQuery !== 'undefined') {
        jQuery(document).on('gm:lightbox:open', function (e, artworkData) {
          self.open(artworkData);
        });
      }
    },

    /**
     * Setup keyboard event handlers
     */
    setupKeyboardHandlers: function () {
      var self = this;

      document.addEventListener('keydown', function (e) {
        if (!self.isVisible()) return;

        switch (e.key) {
          case 'Escape':
            self.close();
            break;
          case 'ArrowLeft':
            if (self.settings.enable_keyboard_nav !== 'no') {
              e.preventDefault();
              self.showPrevious();
            }
            break;
          case 'ArrowRight':
            if (self.settings.enable_keyboard_nav !== 'no') {
              e.preventDefault();
              self.showNext();
            }
            break;
          case 'Tab':
            // Trap focus within modal
            self.handleTabKey(e);
            break;
        }
      });
    },

    /**
     * Trap focus within modal
     */
    handleTabKey: function (e) {
      var self = this;
      var focusableElements = self.$lightbox.querySelectorAll(
        'button:not(:disabled), a[href], [tabindex]:not([tabindex="-1"])'
      );
      var firstEl = focusableElements[0];
      var lastEl = focusableElements[focusableElements.length - 1];

      if (e.shiftKey && document.activeElement === firstEl) {
        e.preventDefault();
        lastEl.focus();
      } else if (!e.shiftKey && document.activeElement === lastEl) {
        e.preventDefault();
        firstEl.focus();
      }
    },

    /**
     * Check if lightbox is visible
     */
    isVisible: function () {
      return this.$lightbox && this.$lightbox.classList.contains('gm-lightbox__overlay--visible');
    },

    /**
     * Open lightbox from custom event (artwork grid)
     */
    openFromEvent: function (detail) {
      var artworkData = {
        id: detail.index || 0,
        title: detail.title || '',
        medium: detail.medium || '',
        year: '',
        dimensions: '',
        image: detail.image || ''
      };

      // Try to extract year from medium string (format: "Medium, Year")
      if (artworkData.medium && artworkData.medium.includes(',')) {
        var parts = artworkData.medium.split(',');
        if (parts.length >= 2) {
          artworkData.year = parts.pop().trim();
          artworkData.medium = parts.join(',').trim();
        }
      }

      this.open(artworkData);
    },

    /**
     * Open lightbox with artwork data
     */
    open: function (artworkData) {
      var self = this;
      if (!artworkData || !self.$lightbox) return;

      self.currentArtwork = artworkData;
      self.previousFocus = document.activeElement;

      // Find index in list if available
      if (self.artworkList.length > 0) {
        self.currentIndex = self.artworkList.findIndex(function (item) {
          return item.id === artworkData.id;
        });
      } else {
        self.currentIndex = typeof artworkData.id === 'number' ? artworkData.id : -1;
      }

      // Update content
      self.updateContent(artworkData);

      // Show lightbox
      self.lockBodyScroll();
      self.$lightbox.classList.remove('gm-lightbox__overlay--hidden');

      // Force reflow for animation
      self.$lightbox.offsetHeight;

      self.$lightbox.classList.add('gm-lightbox__overlay--visible');
      if (self.settings.enable_entrance_animation !== 'no') {
        self.$lightbox.classList.add('gm-lightbox__overlay--animate');
      }

      // Update navigation states
      self.updateNavigationState();

      // Focus management - focus close button
      var $closeBtn = self.$lightbox.querySelector('.gm-lightbox__close');
      if ($closeBtn) {
        setTimeout(function () {
          $closeBtn.focus();
        }, 50);
      }

      // Update ARIA
      self.$lightbox.setAttribute('aria-hidden', 'false');
    },

    /**
     * Close lightbox
     */
    close: function () {
      var self = this;
      if (!self.$lightbox) return;

      self.$lightbox.classList.remove('gm-lightbox__overlay--visible', 'gm-lightbox__overlay--animate');

      var duration = self.settings.animation_duration || 300;

      setTimeout(function () {
        self.$lightbox.classList.add('gm-lightbox__overlay--hidden');
        self.unlockBodyScroll();
        self.$lightbox.setAttribute('aria-hidden', 'true');

        // Return focus to previous element
        if (self.previousFocus && typeof self.previousFocus.focus === 'function') {
          self.previousFocus.focus();
        }
      }, duration);

      self.currentArtwork = null;
      self.currentIndex = -1;
    },

    /**
     * Update lightbox content with artwork data
     */
    updateContent: function (artwork) {
      var self = this;
      var $title = self.$lightbox.querySelector('.gm-lightbox__title');
      var $image = self.$lightbox.querySelector('.gm-lightbox__image');
      var $medium = self.$lightbox.querySelector('.gm-lightbox__details--medium');
      var $year = self.$lightbox.querySelector('.gm-lightbox__details--year');
      var $dimensions = self.$lightbox.querySelector('.gm-lightbox__dimensions');
      var $cta = self.$lightbox.querySelector('.gm-lightbox__cta');

      // Update text content
      if ($title) $title.textContent = artwork.title || '';
      if ($medium) $medium.textContent = artwork.medium || '';
      if ($year) $year.textContent = artwork.year || '';

      // Update dimensions (optional)
      if ($dimensions) {
        if (artwork.dimensions && self.settings.show_dimensions !== 'no') {
          $dimensions.textContent = artwork.dimensions;
          $dimensions.style.display = '';
        } else {
          $dimensions.style.display = 'none';
        }
      }

      // Update image
      if ($image && artwork.image) {
        $image.src = artwork.image;
        $image.alt = artwork.title || '';
      }

      // Update CTA link with url params
      if ($cta && self.settings.enable_url_params === 'yes' && artwork.title) {
        var baseUrl = self.settings.cta_button_url || '/kontakt';
        var ctaUrl = baseUrl + '?werk=' + encodeURIComponent(artwork.title);
        $cta.href = ctaUrl;
      }
    },

    /**
     * Show previous artwork
     */
    showPrevious: function () {
      var self = this;
      if (self.currentIndex <= 0 || self.artworkList.length === 0) return;

      var prevArtwork = self.artworkList[self.currentIndex - 1];
      if (prevArtwork) {
        self.open(prevArtwork);
      }
    },

    /**
     * Show next artwork
     */
    showNext: function () {
      var self = this;
      if (self.currentIndex >= self.artworkList.length - 1 || self.artworkList.length === 0) return;

      var nextArtwork = self.artworkList[self.currentIndex + 1];
      if (nextArtwork) {
        self.open(nextArtwork);
      }
    },

    /**
     * Update navigation button states
     */
    updateNavigationState: function () {
      var self = this;
      var $prevBtn = self.$lightbox.querySelector('.gm-lightbox__nav-button--prev');
      var $nextBtn = self.$lightbox.querySelector('.gm-lightbox__nav-button--next');

      if (self.settings.show_navigation === 'no') {
        if ($prevBtn) $prevBtn.style.display = 'none';
        if ($nextBtn) $nextBtn.style.display = 'none';
        return;
      }

      // Disable when no artwork list
      if (self.artworkList.length === 0) {
        if ($prevBtn) $prevBtn.disabled = true;
        if ($nextBtn) $nextBtn.disabled = true;
        return;
      }

      // Previous button
      if ($prevBtn) {
        $prevBtn.disabled = self.currentIndex <= 0;
      }

      // Next button
      if ($nextBtn) {
        $nextBtn.disabled = self.currentIndex >= self.artworkList.length - 1;
      }
    },

    /**
     * Set artwork list for navigation
     */
    setArtworkList: function (list) {
      this.artworkList = list || [];
    },

    /**
     * Lock body scroll
     */
    lockBodyScroll: function () {
      document.body.classList.add('gm-lightbox-open');
      var scrollbarWidth = this.getScrollbarWidth();
      document.body.style.paddingRight = scrollbarWidth + 'px';
    },

    /**
     * Unlock body scroll
     */
    unlockBodyScroll: function () {
      document.body.classList.remove('gm-lightbox-open');
      document.body.style.paddingRight = '';
    },

    /**
     * Get scrollbar width to prevent layout shift
     */
    getScrollbarWidth: function () {
      var outer = document.createElement('div');
      outer.style.visibility = 'hidden';
      outer.style.overflow = 'scroll';
      outer.style.msOverflowStyle = 'scrollbar';
      document.body.appendChild(outer);

      var inner = document.createElement('div');
      outer.appendChild(inner);

      var scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
      outer.parentNode.removeChild(outer);

      return scrollbarWidth;
    }
  };

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      GMArtworkLightbox.init();
    });
  } else {
    GMArtworkLightbox.init();
  }

  // Re-initialize when Elementor frontend loads
  if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
      if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction(
          'frontend/element_ready/gm_artwork_lightbox.default',
          function ($scope) {
            GMArtworkLightbox.init();
          }
        );
      }
    });
  }

  // Expose for external use
  window.gmLightbox = GMArtworkLightbox;
  window.GMArtworkLightbox = GMArtworkLightbox;
})();
