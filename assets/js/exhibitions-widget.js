(function () {
    'use strict';

    /* -------------------------------------------------- */
    /*  Double-init guard                                  */
    /* -------------------------------------------------- */
    function initExhibitionsWidget(container) {
        if (!container) return;
        if (container.dataset.gmWidgetInit === 'true') return;
        container.dataset.gmWidgetInit = 'true';

        /* ---- DOM refs ---- */
        var inner    = container.querySelector('.gm-exhibitions__inner');
        var cards    = container.querySelectorAll('.gm-exhibitions__card');
        var modal    = container.querySelector('.gm-exhibitions__modal');
        var backdrop = container.querySelector('.gm-exhibitions__modal-backdrop');
        var closeBtn = container.querySelector('.gm-exhibitions__modal-close');
        var gallery  = container.querySelector('.gm-exhibitions__modal-gallery');
        var imgEl    = container.querySelector('.gm-exhibitions__modal-image');
        var prevBtn  = container.querySelector('.gm-exhibitions__modal-prev');
        var nextBtn  = container.querySelector('.gm-exhibitions__modal-next');
        var dotsWrap = container.querySelector('.gm-exhibitions__modal-dots');
        var titleEl  = container.querySelector('.gm-exhibitions__modal-title');
        var yearEl   = container.querySelector('.gm-exhibitions__modal-year');
        var locEl    = container.querySelector('.gm-exhibitions__modal-location');
        var descEl   = container.querySelector('.gm-exhibitions__modal-description');

        /* ---- Exhibition data (parsed from data-* on cards) ---- */
        var exhibitions = [];
        cards.forEach(function (card) {
            exhibitions.push({
                title:       card.dataset.title       || '',
                year:        card.dataset.year        || '',
                location:    card.dataset.location    || '',
                description: card.dataset.description || '',
                images:      JSON.parse(card.dataset.images || '[]')
            });
        });

        var currentExhibition = -1;
        var currentImage = 0;

        /* ---- Fade-up animation ---- */
        var enableFadeUp = container.dataset.fadeUp !== 'no';
        if (enableFadeUp && inner) {
            var threshold = parseFloat(container.dataset.fadeThreshold) || 0.15;
            inner.classList.add('gm-exhibitions__inner--hidden');

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        inner.classList.remove('gm-exhibitions__inner--hidden');
                        inner.classList.add('gm-exhibitions__inner--animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: threshold });
            observer.observe(inner);
        }

        /* ---- Open modal ---- */
        function openModal(index) {
            currentExhibition = index;
            currentImage = 0;
            var ex = exhibitions[index];
            if (!ex) return;

            titleEl.textContent = ex.title;
            yearEl.textContent  = ex.year;
            locEl.textContent   = ex.location;
            descEl.textContent  = ex.description;

            renderGallery(ex);

            modal.classList.add('gm-exhibitions__modal--open');
            modal.style.display = '';
            document.body.style.overflow = 'hidden';
        }

        /* ---- Close modal ---- */
        function closeModal() {
            modal.classList.remove('gm-exhibitions__modal--open');
            modal.style.display = 'none';
            document.body.style.overflow = '';
            currentExhibition = -1;
        }

        /* ---- Render gallery image + dots ---- */
        function renderGallery(ex) {
            imgEl.src = ex.images[currentImage] || '';
            imgEl.alt = ex.title + ' — Bild ' + (currentImage + 1);

            // Show/hide nav arrows
            var hasMultiple = ex.images.length > 1;
            if (prevBtn) prevBtn.style.display = hasMultiple ? '' : 'none';
            if (nextBtn) nextBtn.style.display = hasMultiple ? '' : 'none';

            // Render dots
            if (dotsWrap) {
                dotsWrap.innerHTML = '';
                dotsWrap.style.display = hasMultiple ? '' : 'none';
                if (hasMultiple) {
                    ex.images.forEach(function (_, i) {
                        var dot = document.createElement('button');
                        dot.className = 'gm-exhibitions__modal-dot' +
                            (i === currentImage ? ' gm-exhibitions__modal-dot--active' : '');
                        dot.setAttribute('aria-label', 'Bild ' + (i + 1));
                        dot.addEventListener('click', function () {
                            currentImage = i;
                            renderGallery(ex);
                        });
                        dotsWrap.appendChild(dot);
                    });
                }
            }
        }

        /* ---- Navigate images ---- */
        function prevImage() {
            var ex = exhibitions[currentExhibition];
            if (!ex) return;
            currentImage = currentImage > 0 ? currentImage - 1 : ex.images.length - 1;
            renderGallery(ex);
        }

        function nextImage() {
            var ex = exhibitions[currentExhibition];
            if (!ex) return;
            currentImage = currentImage < ex.images.length - 1 ? currentImage + 1 : 0;
            renderGallery(ex);
        }

        /* ---- Event listeners ---- */
        cards.forEach(function (card, index) {
            card.addEventListener('click', function () {
                openModal(index);
            });
        });

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (backdrop) backdrop.addEventListener('click', closeModal);
        if (prevBtn)  prevBtn.addEventListener('click', prevImage);
        if (nextBtn)  nextBtn.addEventListener('click', nextImage);

        document.addEventListener('keydown', function (e) {
            if (currentExhibition < 0) return;
            if (e.key === 'Escape')     closeModal();
            if (e.key === 'ArrowLeft')  prevImage();
            if (e.key === 'ArrowRight') nextImage();
        });
    }

    /* -------------------------------------------------- */
    /*  Init: page load                                    */
    /* -------------------------------------------------- */
    function initAll() {
        document.querySelectorAll('.gm-exhibitions').forEach(initExhibitionsWidget);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    /* -------------------------------------------------- */
    /*  Init: Elementor editor (frontend/element_ready)    */
    /* -------------------------------------------------- */
    if (window.jQuery) {
        jQuery(window).on('elementor/frontend/init', function () {
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction(
                    'frontend/element_ready/gm_exhibitions.default',
                    function ($scope) {
                        var el = $scope[0].querySelector('.gm-exhibitions');
                        if (el) initExhibitionsWidget(el);
                    }
                );
            }
        });
    }
})();
