/**
 * Setzt die Sprache für den CookieManager.
 * @param {string} lang - Der Sprachcode (z.B. 'de', 'en')
 */
function setCookieManagerLanguage(lang) {
    window.addEventListener('load', function() {
        if (typeof CookieConsent !== 'undefined') {
            CookieConsent.setLanguage(lang, true);
        }
    });
}