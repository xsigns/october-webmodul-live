(function () {
    'use strict';

    var selector = 'form[data-request$="::onRatingSave"]';

    function showMessage(form, message) {
        var status = form.querySelector('[data-rating-protection-status]');
        if (status) {
            status.textContent = message;
        }
    }

    function installProof(form, challenge) {
        var previous = form.querySelector('altcha-widget[data-rating-proof]');
        if (previous) {
            previous.remove();
        }

        form.elements.rating_altcha.value = '';
        form.dataset.ratingProofState = 'verifying';
        var widget = document.createElement('altcha-widget');
        widget.setAttribute('data-rating-proof', '');
        widget.setAttribute('auto', 'onload');
        widget.setAttribute('display', 'invisible');
        widget.setAttribute('name', 'rating_altcha_widget');
        widget.setAttribute('challenge', JSON.stringify(challenge));
        widget.setAttribute('configuration', JSON.stringify({
            humanInteractionSignature: false, minDuration: 0, workers: 1, timeout: 60000
        }));
        widget.addEventListener('verified', function (event) {
            if (!form.contains(widget) || !event.detail || !event.detail.payload) {
                return;
            }
            form.elements.rating_altcha.value = event.detail.payload;
            form.dataset.ratingProofState = 'verified';
            if (!form.dataset.ratingErrorMessage) {
                showMessage(form, '');
            }
            if (form.dataset.ratingSubmitWaiting === '1') {
                form.dataset.ratingSubmitWaiting = '0';
                form.requestSubmit ? form.requestSubmit() : form.querySelector('[type="submit"]').click();
            }
        });
        widget.addEventListener('statechange', function (event) {
            if (form.contains(widget) && event.detail.state === 'error') {
                form.dataset.ratingProofState = 'error';
                form.dataset.ratingSubmitWaiting = '0';
                showMessage(form, 'Die Rechenprüfung ist fehlgeschlagen. Bitte versuchen Sie es erneut.');
            }
        });
        widget.addEventListener('expired', function () {
            if (!form.contains(widget)) {
                return;
            }
            form.elements.rating_altcha.value = '';
            requestChallenge(form);
        });
        form.appendChild(widget);
        window.setTimeout(function () {
            if (form.contains(widget) && form.dataset.ratingProofState === 'verifying') {
                form.dataset.ratingProofState = 'error';
                form.dataset.ratingSubmitWaiting = '0';
                showMessage(form, 'Die Rechenprüfung konnte nicht abgeschlossen werden. Bitte versuchen Sie es erneut.');
            }
        }, 65000);
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
                if (data.ratingChallenge && data.altchaChallenge) {
                    form.elements.rating_challenge.value = data.ratingChallenge;
                    installProof(form, data.altchaChallenge);
                    if (!form.dataset.ratingErrorMessage) {
                        showMessage(form, '');
                    }
                } else {
                    form.dataset.ratingProofState = 'error';
                    form.dataset.ratingSubmitWaiting = '0';
                    showMessage(form, data.ratingProtectionError || 'Der Bewertungsschutz ist derzeit nicht verfügbar.');
                }
            })
            .fail(function () {
                form.dataset.ratingChallengePending = '0';
                form.dataset.ratingProofState = 'error';
                form.dataset.ratingSubmitWaiting = '0';
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

        var proof = document.createElement('input');
        proof.name = 'rating_altcha';
        proof.type = 'hidden';
        form.appendChild(proof);

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
        if (form.elements.rating_challenge.value && form.elements.rating_altcha.value) {
            form.dataset.ratingErrorMessage = '';
            showMessage(form, '');
            return;
        }

        event.preventDefault();
        event.stopImmediatePropagation();
        form.dataset.ratingSubmitWaiting = '1';
        form.dataset.ratingErrorMessage = '';
        showMessage(form, 'Die unsichtbare Rechenprüfung läuft. Ihre Eingaben bleiben erhalten.');
        if (form.dataset.ratingProofState !== 'verifying') {
            requestChallenge(form);
        }
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
            form.elements.rating_altcha.value = '';
            form.dataset.ratingSubmitWaiting = '0';
            form.dataset.ratingErrorMessage = data.ratingProtectionError;
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
