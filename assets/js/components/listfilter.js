$(function () {
    $('#subtractPerson,#addPerson,#subtractZimmer,#addZimmer,#subtractSchlafzimmer,#addSchlafzimmer,#subtractBadezimmer,#addBadezimmer').bind('click', function(e) {
        aenderePerson(e)
        aendereZimmer(e)
        aendereSchlafzimmer(e)
        aendereBadezimmer(e)
    }).bind('keypress', function(e) {
        if (e.which === 13) {
            aenderePerson(e)
            aendereZimmer(e)
            aendereSchlafzimmer(e)
            aendereBadezimmer(e)
        }
    })
})

function aenderePerson(e) {
    if (e.target.id === 'subtractPerson')
        aendereFilterWert('#personen', '#perswert', false, 'onDataChange', e.target.id);
    else if (e.target.id === 'addPerson')
        aendereFilterWert('#personen', '#perswert', true, 'onDataChange', e.target.id);
}

function aendereZimmer(e) {
    if (e.target.id === 'subtractZimmer')
        aendereFilterWert('#zimmer', '#zimmerwert', false, 'onDataChange', e.target.id);
    else if (e.target.id === 'addZimmer')
        aendereFilterWert('#zimmer', '#zimmerwert', true, 'onDataChange', e.target.id);
}

function aendereSchlafzimmer(e) {
    if (e.target.id === 'subtractSchlafzimmer')
        aendereFilterWert('#schlafzimmer', '#schlafzimmerwert', false, 'onDataChange', e.target.id);
    else if (e.target.id === 'addSchlafzimmer')
        aendereFilterWert('#schlafzimmer', '#schlafzimmerwert', true, 'onDataChange', e.target.id);
}

function aendereBadezimmer(e) {
    if (e.target.id === 'subtractBadezimmer')
        aendereFilterWert('#badezimmer', '#badezimmerwert', false, 'onDataChange', e.target.id);
    else if (e.target.id === 'addBadezimmer')
        aendereFilterWert('#badezimmer', '#badezimmerwert', true, 'onDataChange', e.target.id);
}

function aendereFilterWert(controlwert, controldarstellung, increment, request, target)
{
    let cwert = $(controlwert);
    let input1 =  parseInt(cwert.val(), 10);

    if (increment)
        input1++;
    else
        input1 --;

    let addplus = true;

    if (controlwert === '#personen' && input1 > maxpersonen) {
        input1 = maxpersonen;
        addplus = false;
    }

    if (controlwert === '#badezimmer' && input1 > maxbadezimmer){
        input1 = maxbadezimmer;
        addplus = false;
    }

    if (controlwert === '#schlafzimmer' && input1 > maxschlafzimmer){
        input1 = maxschlafzimmer;
        addplus = false;
    }

    if (controlwert === '#zimmer' && input1 > maxzimmer){
        input1 = maxzimmer;
        addplus = false;
    }

    if (input1 < 1) {
        if (controlwert === '#personen')
            input1 = 1;
        else
            input1 = 0;
    }

    cwert.val(input1);

    if (addplus)
        $(controldarstellung).text(input1 + '+');
    else
        $(controldarstellung).text(input1);

    resetpage = true;

    cwert.request(request, {
        success: function() {
            $('#' + target).focus();
        }
    });
}
