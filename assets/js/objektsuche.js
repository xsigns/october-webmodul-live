/**
 * Reservation form.
 *
 * @param $ jQuery
 */
var objektsuche = function($) {

    var from_$input = $('#fromdate').pickadate(),
        from_picker = from_$input.pickadate('picker')

    var to_$input = $('#todate').pickadate(),
        to_picker = to_$input.pickadate('picker')
// Check if there’s a “from” or “to” date to start with.
    if ( from_picker.get('value') ) {
        var result = new Date(from_picker.get('select','yyyy/mm/dd'));
        result.setDate(result.getDate() + 1);
        to_picker.set('min', result);
    }
    if ( to_picker.get('value') ) {
        from_picker.set('max', to_picker.get('select'))
    }

// When something is selected, update the “from” and “to” limits.
    from_picker.on('set', function(event) {
        if ( event.select ) {
            var result = new Date(from_picker.get('select','yyyy/mm/dd'));
        result.setDate(result.getDate() + 1);
            to_picker.set('min', result);
            to_picker.open(); //Wenn Anreise gewählt dann öffne Abreis
        }
        else if ( 'clear' in event ) {
            to_picker.set('min', false)
        }

    })
    to_picker.on('set', function(event) {
        if ( event.select ) {
            from_picker.set('max', to_picker.get('select'))
        }
        else if ( 'clear' in event ) {
            from_picker.set('max', false)
        }
    });
};
jQuery(document).ready(objektsuche);
