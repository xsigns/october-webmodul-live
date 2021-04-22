/********************************************************************/
/* Copyright 2014-2016 xsigns GmbH & Co. KG */
/* Author : Jörg Möbes, Andre Litfin */
/* FewoVerwalter Webmodul */
/*********************************************************************/

var gewaehlterMonatID = 0;
var BuchungJS;

function InitialisiereKalender(callback) {

    var jqobjComboSaisonwaehler, jqobjCtrlCalIndex, jqobjCtrlCalPrev, jqobjCtrlCalNext;

    jqobjComboSaisonwaehler = jQuery('#ctrlSaisonSelect');

    if (!jqobjComboSaisonwaehler) return;

    jqobjCtrlCalPrev = jQuery('#ctrlCalPrev');
    jqobjCtrlCalNext = jQuery('#ctrlCalNext');

    if (jqobjComboSaisonwaehler.val() > 0) {
        gewaehlterMonatID = jqobjComboSaisonwaehler.val();
    }

    if (jqobjCtrlCalPrev) {
        jqobjCtrlCalPrev.on('click', function () {
            gewaehlterMonatID--;
            waehleMonat(undefined, callback, false);
        });
    }

    jqobjComboSaisonwaehler.on('change', function () {

        jQuery("html").addClass("wait");
        gewaehlterMonatID = this[this.selectedIndex].value;
        jQuery.ajax({
            url: document.location.href,
            method: 'get',
            data: 'fewoBookingPlanAjax=1&aktMonatsIndex=' + gewaehlterMonatID + '&anreise=' + jQuery('#ctrl_anreise').val() + '&abreise=' + jQuery('#ctrl_abreise').val(),
            success: function (resp, textStatus, jqXHR) {
                var data = JSON.parse(resp);
                gewaehlterMonatID = data.monatsindex;
                jQuery('#ctrlBookingPlans').html(data.html);
                jQuery("html").removeClass("wait");
                if (BuchungJS && typeof BuchungJS === 'function')
                    BuchungJS.aktualisiereKalender();
                if (callback && typeof(callback) === 'function')
                    callback();
            }
        });
    });

    if (jqobjCtrlCalNext) {
        jqobjCtrlCalNext.on('click', function () {
            gewaehlterMonatID++;
            waehleMonat(undefined, callback, false);
        });
    }

    if (gewaehlterMonatID == 0) {
        jqobjCtrlCalPrev.addClass('disabled');
    }

    jQuery('#ctrlBookingPlans').swipe({
        swipe: function (event, direction, distance, duration, fingerCount, fingerData) {

            var preventDefaultEvents = true;
            if (direction == 'left') {
                gewaehlterMonatID++;
                if (gewaehlterMonatID > maxMonate)
                    gewaehlterMonatID = maxMonate;
                waehleMonat(undefined, callback, false);
            }
            else if (direction == 'right') {
                gewaehlterMonatID--;
                if (gewaehlterMonatID < 0)
                    gewaehlterMonatID = 0;
                waehleMonat(undefined, callback, false);
            }
            else
                preventDefaultEvents = true;
        },
        swipeStatus: function(event, phase, direction, distance, duration, fingers, fingerData, currentDirection) {
            var preventDefaultEvents = direction === 'up' || direction === 'down';
            if (this && jQuery(this))
                jQuery(this).swipe('option', 'preventDefaultEvents', preventDefaultEvents);
        }
    });
}

jQuery(document).ready(function () {
    InitialisiereKalender();
});

function waehleMonat(monate, callback, benutzeAnAbreise) {

    var jqobjHtml, jqobjCtrlCalPrev, jqobjCtrlCalNext, data;

    jqobjHtml = jQuery("html");
    jqobjCtrlCalPrev = jQuery('#ctrlCalPrev');
    jqobjCtrlCalNext = jQuery('#ctrlCalNext');

    jqobjHtml.addClass("wait");
    if (monate) {
        if (monate == 1)
            gewaehlterMonatID = monate - 1;
        else
            gewaehlterMonatID = monate;
    }
    if (gewaehlterMonatID < 0) {
        gewaehlterMonatID = 0;
        jqobjHtml.removeClass("wait");
        return;
    }

    if (gewaehlterMonatID > maxMonate) {
        gewaehlterMonatID = maxMonate;
        jqobjCtrlCalNext.addClass('disabled');
        jqobjHtml.removeClass("wait");
        return;
    }

    if (gewaehlterMonatID == maxMonate)
        jqobjCtrlCalNext.addClass('disabled');
    else
        jqobjCtrlCalNext.removeClass('disabled');

    if (gewaehlterMonatID <= 0)
        jqobjCtrlCalPrev.addClass('disabled');
    else
        jqobjCtrlCalPrev.removeClass('disabled');
    data = 'fewoBookingPlanAjax=1&aktMonatsIndex=' + gewaehlterMonatID + '&anreise=' + jQuery('#ctrl_anreise').val() + '&abreise=' + jQuery('#ctrl_abreise').val();
    jQuery.ajax({
        url: location.protocol + '//' + location.host + '/belplan',
        method: 'get',
        data: data,
        success: function (resp, textStatus, jqXHR) {
            var data = JSON.parse(resp);

            gewaehlterMonatID = data.monatsindex;
            jQuery('#ctrlSaisonSelect').val(data.monatsindex);
            jQuery('#ctrlBookingPlans').html(data.html);

            if (benutzeAnAbreise) {

                var datum, arrdatum;
                datum = jQuery('#ctrl_anreise').val();
                if (datum && datum !== '') {
                    waehleanreise = true;
                    arrdatum = datum.split('.');
                    BuchungJS.waehleDatum(arrdatum[2] + arrdatum[1] + arrdatum[0], 0, 1);
                }

                datum = jQuery('#ctrl_abreise').val();
                if (datum && datum !== '') {
                    arrdatum = datum.split('.');
                    BuchungJS.waehleDatum(arrdatum[2] + arrdatum[1] + arrdatum[0], 0, 2);
                }
            }

            jQuery("html").removeClass("wait");

            if (BuchungJS && typeof BuchungJS === 'function')
                BuchungJS.aktualisiereKalender();
            if (callback && typeof(callback) === 'function')
                callback();
        }
    });
}