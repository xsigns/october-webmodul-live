(function () {
    'use strict';

    var selector = 'form[data-request$="::onRatingSave"]';

    function showMessage(form, message) {
        var status = form.querySelector('[data-rating-protection-status]');
        if (status) {
            status.textContent = message;
        }
    }

    function requestChallenge(form) {
        if (form.dataset.ratingChallengePending === '1' || !window.jQuery || !jQuery.fn.request) {
            return;
        }

        form.dataset.ratingChallengePending = '1';
        var handler = form.getAttribute('data-request').replace(/onRatingSave$/, 'onRatingChallenge');
        jQuery.request(handler, { data: { objid: form.elements.objid.value } })
            .done(function (data) {
                form.dataset.ratingChallengePending = '0';
                if (data.ratingChallenge) {
                    form.elements.rating_challenge.value = data.ratingChallenge;
                    showMessage(form, '');
                } else {
                    showMessage(form, data.ratingProtectionError || 'Der Bewertungsschutz ist derzeit nicht verfügbar.');
                }
            })
            .fail(function () {
                form.dataset.ratingChallengePending = '0';
                showMessage(form, 'Der Bewertungsschutz ist derzeit nicht verfügbar. Bitte versuchen Sie es später erneut.');
            });
    }

    function prepare(form) {
        if (form.dataset.ratingProtectionReady === '1') {
            return;
        }

        form.dataset.ratingProtectionReady = '1';
        var trap = document.createElement('input');
        trap.name = 'rating_website';
        trap.type = 'text';
        trap.tabIndex = -1;
        trap.autocomplete = 'off';
        trap.setAttribute('aria-hidden', 'true');
        trap.style.cssText = 'position:absolute;left:-10000px;width:1px;height:1px;';
        form.appendChild(trap);

        var challenge = document.createElement('input');
        challenge.name = 'rating_challenge';
        challenge.type = 'hidden';
        form.appendChild(challenge);

        var status = document.createElement('div');
        status.setAttribute('data-rating-protection-status', '');
        status.setAttribute('role', 'status');
        status.setAttribute('aria-live', 'polite');
        form.appendChild(status);

        requestChallenge(form);
    }

    function prepareAll() {
        document.querySelectorAll(selector).forEach(prepare);
    }

    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form.matches(selector)) {
            return;
        }

        prepare(form);
        if (form.elements.rating_challenge.value) {
            return;
        }

        event.preventDefault();
        event.stopImmediatePropagation();
        showMessage(form, 'Der Bewertungsschutz wird vorbereitet. Bitte versuchen Sie es gleich erneut.');
        requestChallenge(form);
    }, true);

    function handleRatingResponse(target, data) {
        if (!(target instanceof Element)) {
            return;
        }

        var form = target.closest(selector);
        if (!form || !data) {
            return;
        }

        if (data.ratingProtectionError && form.dataset.ratingChallengePending !== '1') {
            form.elements.rating_challenge.value = '';
            showMessage(form, data.ratingProtectionError);
            requestChallenge(form);
        }
    }

    document.addEventListener('ajax:request-success', function (event) {
        handleRatingResponse(event.target, event.detail && event.detail.data);
    });

    if (window.jQuery) {
        jQuery(document).on('ajaxSuccess', function (event, context, data) {
            handleRatingResponse(event.target, data);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', prepareAll);
    } else {
        prepareAll();
    }

    new MutationObserver(prepareAll).observe(document.documentElement, { childList: true, subtree: true });
}());
