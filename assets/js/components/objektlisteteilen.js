$(document).ready(function () {
    $('#createLink').click(function () {
        $.request('onCreateLink', {
            success: function(data) {
                navigator.clipboard.writeText(data.result).then(function() {
                    $.oc.flashMsg({
                        'text': successText,
                        'class': 'success',
                        'interval': 5
                    })
                }, function() {
                    alert('Fehler: Speichern in Zwischenablage fehlerhaft');
                });
            }
        });
    });
});