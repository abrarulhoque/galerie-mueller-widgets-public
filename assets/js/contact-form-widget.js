/* ==========================================================================
   Contact Form Widget - Galerie Mueller
   JavaScript: AJAX submission, fade-up animation, form states
   ========================================================================== */

(function () {
  'use strict';

  /* -----------------------------------------------------------------------
     1. Fade-Up Animation (IntersectionObserver)
     ----------------------------------------------------------------------- */
  function initFadeUp() {
    var containers = document.querySelectorAll('.gm-contact-form__container[data-fade-up="true"]');

    if (!containers.length) return;
    if (!('IntersectionObserver' in window)) {
      // Fallback: show immediately if no IO support
      containers.forEach(function (el) {
        el.classList.remove('gm-contact-form__container--hidden');
        el.classList.add('gm-contact-form__container--visible');
      });
      return;
    }

    containers.forEach(function (container) {
      var threshold = parseFloat(container.getAttribute('data-threshold')) || 0.15;
      var duration = parseInt(container.getAttribute('data-duration'), 10) || 700;
      var distance = parseInt(container.getAttribute('data-distance'), 10) || 20;

      // Set custom animation properties via CSS custom properties
      container.style.setProperty('--gm-cf-duration', duration + 'ms');
      container.style.setProperty('--gm-cf-distance', distance + 'px');

      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.remove('gm-contact-form__container--hidden');
              entry.target.classList.add('gm-contact-form__container--visible');
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: threshold }
      );

      observer.observe(container);
    });
  }

  /* -----------------------------------------------------------------------
     2. AJAX Form Submission
     ----------------------------------------------------------------------- */
  function initForms() {
    var forms = document.querySelectorAll('.gm-contact-form__form');

    forms.forEach(function (form) {
      form.addEventListener('submit', handleSubmit);
    });
  }

  function handleSubmit(e) {
    e.preventDefault();

    var form = e.currentTarget;
    var widget = form.closest('.gm-contact-form');
    var submitBtn = form.querySelector('.gm-contact-form__submit');
    var errorEl = form.querySelector('.gm-contact-form__error');
    var successEl = widget.querySelector('.gm-contact-form__success');

    // Read settings from data attributes
    var ajaxUrl = form.getAttribute('data-ajax-url');
    var nonce = form.getAttribute('data-nonce');
    var loadingText = submitBtn.getAttribute('data-loading-text') || 'Wird gesendet...';
    var originalText = submitBtn.getAttribute('data-original-text') || submitBtn.textContent;
    var errorMessage = form.getAttribute('data-error-message') || 'Es ist ein Fehler aufgetreten.';

    // Honeypot check (client-side: silently "succeed" if filled)
    var honeypotName = form.getAttribute('data-honeypot');
    if (honeypotName) {
      var honeypotField = form.querySelector('input[name="' + honeypotName + '"]');
      if (honeypotField && honeypotField.value) {
        // Bot detected: fake success
        showSuccess(form, successEl);
        return;
      }
    }

    // Client-side validation
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    // Set loading state
    submitBtn.disabled = true;
    submitBtn.textContent = loadingText;
    if (errorEl) {
      errorEl.style.display = 'none';
      errorEl.textContent = '';
    }

    // Build FormData
    var formData = new FormData(form);
    formData.append('action', 'gm_contact_submit');
    formData.append('_nonce', nonce);

    // Also pass along widget settings stored as data attributes
    var widgetId = form.getAttribute('data-widget-id') || '';
    formData.append('widget_id', widgetId);

    // Remove honeypot from submission data
    if (honeypotName) {
      formData.delete(honeypotName);
    }

    // AJAX request
    fetch(ajaxUrl, {
      method: 'POST',
      body: formData,
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data.success) {
          showSuccess(form, successEl);
        } else {
          showError(form, errorEl, data.data && data.data.message ? data.data.message : errorMessage);
          submitBtn.disabled = false;
          submitBtn.textContent = originalText;
        }
      })
      .catch(function () {
        showError(form, errorEl, errorMessage);
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      });
  }

  function showSuccess(form, successEl) {
    form.classList.add('gm-contact-form__form--hidden');
    if (successEl) {
      successEl.classList.add('gm-contact-form__success--active');
    }
  }

  function showError(form, errorEl, message) {
    if (errorEl) {
      errorEl.textContent = message;
      errorEl.style.display = 'block';
    }
  }

  /* -----------------------------------------------------------------------
     3. Initialize on DOMContentLoaded & Elementor frontend/init
     ----------------------------------------------------------------------- */
  function init() {
    initFadeUp();
    initForms();
  }

  // Standard page load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Elementor frontend: re-init when widget is loaded/edited
  if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
      if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction(
          'frontend/element_ready/gm_contact_form.default',
          function ($scope) {
            var container = $scope[0].querySelector('.gm-contact-form__container[data-fade-up="true"]');
            if (container) {
              container.classList.remove('gm-contact-form__container--hidden');
              container.classList.add('gm-contact-form__container--visible');
            }
            // Re-bind forms within this scope
            var forms = $scope[0].querySelectorAll('.gm-contact-form__form');
            forms.forEach(function (form) {
              // Remove existing listener to prevent duplicates
              form.removeEventListener('submit', handleSubmit);
              form.addEventListener('submit', handleSubmit);
            });
          }
        );
      }
    });
  }
})();
