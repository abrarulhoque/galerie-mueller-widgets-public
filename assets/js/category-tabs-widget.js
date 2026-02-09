/*
 * Galerie Mueller - Category Tabs Widget Frontend Script
 * Handles tab switching, URL updates, and active state management
 */
(function () {
  'use strict';

  function initCategoryTabs() {
    var widgets = document.querySelectorAll('.gm-category-tabs');

    widgets.forEach(function (widget) {
      var tabs = widget.querySelectorAll('.gm-category-tabs__tab');
      var baseUrl = widget.getAttribute('data-base-url') || '/galerie';
      var paramName = widget.getAttribute('data-param-name') || 'kategorie';

      // Get current active tab from URL
      var currentParams = new URLSearchParams(window.location.search);
      var currentCategory = currentParams.get(paramName);

      // Set initial active state based on URL
      updateActiveTab(tabs, currentCategory);

      // Add click handlers
      tabs.forEach(function (tab) {
        tab.addEventListener('click', function (e) {
          var tabValue = tab.getAttribute('data-tab-value');
          var customUrl = tab.getAttribute('data-custom-url');

          // If custom URL is set, use it directly
          if (customUrl) {
            window.location.href = customUrl;
            return;
          }

          // Otherwise, prevent default and handle URL update
          e.preventDefault();

          var newUrl = buildTabUrl(baseUrl, paramName, tabValue);

          // Update browser URL without page reload
          if (window.history && window.history.pushState) {
            window.history.pushState({ category: tabValue }, '', newUrl);

            // Update active state
            updateActiveTab(tabs, tabValue);

            // Trigger custom event for other components to listen
            var event = new CustomEvent('categoryTabChanged', {
              detail: {
                category: tabValue,
                url: newUrl,
                widget: widget
              }
            });
            document.dispatchEvent(event);
          } else {
            // Fallback for older browsers
            window.location.href = newUrl;
          }
        });
      });

      // Handle browser back/forward buttons
      window.addEventListener('popstate', function (e) {
        var params = new URLSearchParams(window.location.search);
        var category = params.get(paramName);
        updateActiveTab(tabs, category);
      });

      // Add accessibility features
      addAccessibilityFeatures(widget);
    });
  }

  function updateActiveTab(tabs, activeValue) {
    tabs.forEach(function (tab) {
      var tabValue = tab.getAttribute('data-tab-value');
      var isActive = tabValue === activeValue || (!tabValue && !activeValue);

      tab.classList.toggle('gm-category-tabs__tab--active', isActive);
      tab.setAttribute('aria-current', isActive ? 'page' : 'false');
    });
  }

  function buildTabUrl(baseUrl, paramName, tabValue) {
    if (!tabValue) {
      // "All" tab - return base URL without parameters
      return baseUrl;
    }

    var url = new URL(baseUrl, window.location.origin);
    url.searchParams.set(paramName, tabValue);

    return url.pathname + url.search;
  }

  function addAccessibilityFeatures(widget) {
    var nav = widget.querySelector('.gm-category-tabs__nav');
    var tabs = widget.querySelectorAll('.gm-category-tabs__tab');

    // Add ARIA attributes to navigation
    if (nav) {
      nav.setAttribute('role', 'tablist');
      nav.setAttribute('aria-label', 'Category filters');
    }

    // Add ARIA attributes to tabs and keyboard navigation
    tabs.forEach(function (tab, index) {
      tab.setAttribute('role', 'tab');
      tab.setAttribute('tabindex', '0');

      // Keyboard navigation
      tab.addEventListener('keydown', function (e) {
        var currentIndex = Array.from(tabs).indexOf(tab);
        var nextTab = null;

        switch (e.key) {
          case 'ArrowLeft':
          case 'ArrowUp':
            nextTab = tabs[currentIndex - 1] || tabs[tabs.length - 1];
            e.preventDefault();
            break;
          case 'ArrowRight':
          case 'ArrowDown':
            nextTab = tabs[currentIndex + 1] || tabs[0];
            e.preventDefault();
            break;
          case 'Home':
            nextTab = tabs[0];
            e.preventDefault();
            break;
          case 'End':
            nextTab = tabs[tabs.length - 1];
            e.preventDefault();
            break;
          case 'Enter':
          case ' ':
            tab.click();
            e.preventDefault();
            break;
        }

        if (nextTab) {
          nextTab.focus();
        }
      });
    });
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCategoryTabs);
  } else {
    initCategoryTabs();
  }

  // Re-initialize when Elementor frontend loads (for live preview)
  if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
      if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction(
          'frontend/element_ready/gm_category_tabs.default',
          function ($scope) {
            // Re-initialize for this specific widget instance
            var widget = $scope[0].querySelector('.gm-category-tabs');
            if (widget) {
              // Remove existing listeners to avoid duplicates
              var tabs = widget.querySelectorAll('.gm-category-tabs__tab');
              tabs.forEach(function (tab) {
                tab.replaceWith(tab.cloneNode(true));
              });

              // Re-initialize
              initCategoryTabs();
            }
          }
        );
      }
    });
  }

  // Expose utility functions globally for other scripts
  window.GMCategoryTabs = {
    updateActiveTab: updateActiveTab,
    buildTabUrl: buildTabUrl
  };
})();
