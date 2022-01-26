var wechselTimeline = wechselleisteBelplan;
var verfuegbarTimeline = verfuegbarleisteBelplan;
var mintageTimeline = mintageleisteBelplan;
var waehleAnreise = !0;
var anreisedatum, abreisedatum;
var anreiseId, abreiseId;
var gewaehlterMonatID = 0;
var verfuegbarleistePrevMonth = null;
var minTageTimelinePrevMonth = null;

$(document).ready(function() {
    InitialisiereKalender();
});

function InitialisiereKalender() {
    $('.ctrlSaisonSelect').on('change', Belplan.calSelect);
    $('.ctrlCalNext').on('click', Belplan.calRight);
    $('.ctrlCalPrev').on('click', Belplan.calLeft);
}

var Belplan = function() {};
Belplan.callback = null;

Belplan.initForm = function (callback) {
    Belplan.callback = callback;
    Belplan.clickEvent();
};

Belplan.calRight = function () {
    $.request('onBtnRight', {
        method: 'post',
        data: {'caloffset' : caloffset, 'calid' : calid},
        success: function(resp) {
            var belPlan = resp['#ctrlBookingPlans_' + calid];
            $('.fewo_buchungsplan').html(belPlan);
            caloffset++;
            $('.ctrlSaisonSelect').val(caloffset);

            if (anreisedatum) {
                if (verfuegbarleistePrevMonth === null)
                    verfuegbarleistePrevMonth = verfuegbarTimeline;

                if (minTageTimelinePrevMonth === null)
                    minTageTimelinePrevMonth = mintageTimeline;
            }

            wechselTimeline = resp['wechselleiste'];
            verfuegbarTimeline = resp['verfuegbarleiste'];
            mintageTimeline = resp['mintageleiste'];
            Belplan.updateCal();
        }
    });
};

Belplan.calLeft = function () {
    $.request('onBtnLeft', {
        method: 'post',
        data: {'caloffset' : caloffset, 'calid' : calid},
        success: function(resp) {
            var belPlan = resp['#ctrlBookingPlans_' + calid];
            $('.fewo_buchungsplan').html(belPlan);
            if (caloffset > 0) {
                caloffset--;
            }

            if (anreisedatum) {
                if (verfuegbarleistePrevMonth === null)
                    verfuegbarleistePrevMonth = verfuegbarTimeline;

                if (minTageTimelinePrevMonth === null)
                    minTageTimelinePrevMonth = mintageTimeline;
            }

            $('.ctrlSaisonSelect').val(caloffset);
            wechselTimeline = resp['wechselleiste'];
            verfuegbarTimeline = resp['verfuegbarleiste'];
            mintageTimeline = resp['mintageleiste']
            Belplan.updateCal();
        }
    });
};

Belplan.calSelect = function () {
    gewaehlterMonatID = this[this.selectedIndex].value;
    $.request('onSelectorChange', {
        method: 'post',
        data: {'calSelector' : gewaehlterMonatID, 'calid' : calid},
        success: function(resp) {
            var belPlan = resp['#ctrlBookingPlans_' + calid];
            $('.fewo_buchungsplan').html(belPlan);
            caloffset = gewaehlterMonatID;

            if (anreisedatum)
                if (verfuegbarleistePrevMonth === null)
                    verfuegbarleistePrevMonth = verfuegbarTimeline;

            wechselTimeline = resp['wechselleiste'];
            verfuegbarTimeline = resp['verfuegbarleiste'];
            mintageTimeline = resp['mintageleiste'];
            Belplan.updateCal();
        }
    });
};

Belplan.updateCal = function () {
    var tag, monat, jahr, elem;

    if (anreisedatum && !abreisedatum) {
        var anreiseElem, arrAnreise, dayEleme, day, wechselStatus, verfuegbarStatus;

        if ($('#ctrl_panreise').val() != undefined)
            anreiseElem = $('#ctrl_panreise').val();
        else
            anreiseElem = $('#ctrl_anreise').val();

        arrAnreise = anreiseElem.split('.');
        tag = arrAnreise[0];
        monat = arrAnreise[1];
        jahr = arrAnreise[2];
        elem = $('#tag_' + jahr + monat + tag);
        dayEleme = $('.tag');
        day = dayEleme.index(elem);
        anreiseClicked(elem, 'C', 'Y', true);
    } else if (anreisedatum && abreisedatum) {
        var abreiseElem, arrAbreise;

        if ($('#ctrl_pabreise').val() != undefined)
            abreiseElem = $('#ctrl_pabreise').val();
        else
            abreiseElem = $('#ctrl_abreise').val();

        arrAbreise = abreiseElem.split('.');
        tag = arrAbreise[0];
        monat = arrAbreise[1];
        jahr = arrAbreise[2];
        elem = $('#tag_' + jahr + monat + tag);
        $(elem).addClass('gewaehlt');
        Belplan.selectAbreise(elem, tag, monat, jahr);
        Belplan.clickEvent();
    } else if (!anreisedatum && !abreisedatum) {
        Belplan.clickEvent();
    }
};

Belplan.clickEvent = function() {
    var dayEleme = $('.tag:not(.nichtselektierbar)');
    if (waehleAnreise) {
        Belplan.addNichtWaehlbarClass();
    }

    dayEleme.off('click');
    dayEleme.click(function() {
        Belplan.waehleDatum(this);
    });
};

Belplan.addNichtWaehlbarClass = function() {
    if (!anreisedatum  && !abreisedatum) {
        const tage = $('.tag');

        for (let i = 0; i < wechselTimeline.length; i++) {

            const wechselstatus = wechselTimeline.charAt(i);
            const verfuegbarStatus = verfuegbarTimeline.charAt(i);

            if (wechselstatus === 'O') {
                tage.eq(i).addClass('nichtwaehlbar').addClass('nichtselektierbar');
            } else if (wechselstatus === 'X' && verfuegbarStatus === 'Y') {
                tage.eq(i).addClass('nichtwaehlbar').addClass('nichtselektierbar');
            } else if (wechselstatus === 'X' && verfuegbarStatus === 'N' && wechselTimeline.charAt(i - 1) === 'X' && verfuegbarTimeline.charAt(i - 1) === 'Y') {
                tage.eq(i).addClass('nichtwaehlbar').addClass('nichtselektierbar');
            }
        }
    }
};

function anreiseClicked(elem, wechselStatus, verfuegbarStatus, hasClicked = false) {
    if (hasClicked === false) {
        if (wechselStatus === 'C' || wechselStatus === 'I' && wechselStatus !== 'O' && verfuegbarStatus === 'Y') {
            var dayEleme, dateId, tag, monat, jahr, dayId, mintage;
            dayEleme = $('.tag');
            dateId = $(elem).attr('id');
            tag = dateId.substr(10, 2);
            monat = dateId.substr(8, 2);
            jahr = dateId.substr(4, 4);
            dayId = dayEleme.index(elem);
            mintage = mintageTimeline.charAt(dayId);
            anreisedatum = new Date(jahr + '-' + monat + '-' + tag);
            anreiseId = dayId;
            dayEleme.removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
            dayEleme.slice(0, dayId).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
            dayEleme.slice(dayId).css('pointer-events', '').removeClass('nichtwaehlbar').removeClass('nichtselektierbar').removeClass('keineanabreise').removeClass('fehleranreisetag').addClass('waehlbar');
            $(elem).addClass('gewaehlt');
            $('#period').val(tag + '.' + monat + '.' + jahr + ' - ');
            $('#ctrl_panreise').val(tag + '.' + monat + '.' + jahr);
            $('#ctrl_anreise').val(tag + '.' + monat + '.' + jahr);
            var verfuegbarZeitraum = verfuegbarTimeline.substring(anreiseId);

            if (verfuegbarZeitraum.includes('N')) {
                var nextBelId = anreiseId + verfuegbarZeitraum.indexOf('N') + 1;
                dayEleme.slice(dayId, nextBelId).removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
                dayEleme.slice(nextBelId).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
            }

            var mintageRange = wechselTimeline.substr(dayId, parseInt(mintage) + 1);

            if (mintageRange.includes('O')) {
                mintage = mintageRange.lastIndexOf('O');
            }

            for (var i = 0; i < mintage; i++) {
                var mintageStatus = wechselTimeline.charAt(dayId + i);

                if (i < mintage) {
                    dayEleme.eq(dayId + i).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
                }
            }

            // alte Logik Mintage
            /*if (mintageRange.includes('X')) {
                var lastOut = mintageRange.lastIndexOf('O');

                for (var i = 0; i < mintage + 1; i++) {
                    var mintageStatus = wechselTimeline.charAt(dayId + i);

                    if (mintageStatus !== 'O' || i < lastOut) {
                        dayEleme.eq(dayId + i).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
                    }
                }
            } else {
                for (var j = 0; j < mintage; j++) {
                    dayEleme.eq(dayId + j).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
                }
            }*/

            waehleAnreise = !1;
            Belplan.clickEvent();
        }
    } else {
        var dayEleme2 = $('.tag');

        if ($(elem).length) {
            var dayId2, mintage2, verfuegbarZeitraum2;

            $(elem).addClass('gewaehlt');
            dayId2 = dayEleme2.index(elem);
            mintage2 = mintageTimeline.charAt(dayId2);
            verfuegbarZeitraum2 = verfuegbarTimeline.substring(dayId2);
            dayEleme2.slice(0, dayId2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');

            if (verfuegbarZeitraum2.includes('N')) {
                var nextBelId2 = dayId2 + verfuegbarZeitraum2.indexOf('N') + 1;
                dayEleme2.slice(dayId2, nextBelId2).removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
                dayEleme2.slice(nextBelId2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
            }

            var mintageRange2 = wechselTimeline.substr(dayId2, parseInt(mintage2) + 1);

            if (mintageRange2.includes('X')) {
                for (let i2 = 0; i2 < mintage2; i2++) {
                    const mintageStatus2 = wechselTimeline.charAt(dayId2 + i2);

                    if (mintageStatus2 !== 'O') {
                        dayEleme2.eq(dayId2 + i2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
                    }
                }
            } else {
                for (let j2 = 0; j2 < mintage2; j2++) {
                    dayEleme2.eq(dayId2 + j2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
                }
            }
        } else {
            var preMonthOffset, preMonthTimeline, firstBelId, mintageFromAnreise;
            preMonthOffset = verfuegbarleistePrevMonth.length - verfuegbarTimeline.length;
            preMonthTimeline = verfuegbarleistePrevMonth.substring(anreiseId, preMonthOffset);
            firstBelId = verfuegbarTimeline.indexOf('N') + 1;
            mintageFromAnreise = minTageTimelinePrevMonth.substr(anreiseId, 1);

            dayEleme2.slice(firstBelId).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');

            if ((preMonthOffset - anreiseId) < mintageFromAnreise)
                dayEleme2.slice(0, mintageFromAnreise - (preMonthOffset - anreiseId)).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');

            if (preMonthTimeline.includes('N'))
                dayEleme2.slice().css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar');
        }

        waehleAnreise = !1;
        Belplan.clickEvent();
    }
};

Belplan.waehleDatum = function (elem) {
    var dayEleme, day, wechselStatus, verfuegbarStatus;
    dayEleme = $('.tag');
    day = dayEleme.index(elem);
    wechselStatus = wechselTimeline.charAt(day);
    verfuegbarStatus = verfuegbarTimeline.charAt(day);

    if (waehleAnreise) {
        Belplan.loescheAuswahl();
        anreiseClicked(elem, wechselStatus, verfuegbarStatus);
    } else {
        if (wechselStatus === 'C' || wechselStatus === 'O' && wechselStatus !== 'I' && wechselStatus !== 'X' || $(elem).hasClass('waehlbar')) {
            var dateId, tag, monat, jahr;
            $(elem).addClass('gewaehlt');
            $('.nichtwaehlbar').css('pointer-events', 'auto').removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
            dateId = $(elem).attr('id');
            tag = dateId.substr(10, 2);
            monat = dateId.substr(8, 2);
            jahr = dateId.substr(4, 4);
            abreisedatum = new Date(jahr + '-' + monat + '-' + tag);

            // Preisrechner
            if($("#ctrl_pabreise").length !== 0)
            {
                var panreise = $('#ctrl_panreise').val();
                $('#period').val(panreise + ' - ' + tag + '.' + monat + '.' + jahr);
                $('#ctrl_pabreise').val(tag + '.' + monat + '.' + jahr);
            }

            // Buchungsmaske
            if ($("#ctrl_abreise").length !== 0)
            {
                var buanreise = $('#ctrl_anreise').val();
                $('#period').val(buanreise + ' - ' + tag + '.' + monat + '.' + jahr);
                $('#ctrl_abreise').val(tag + '.' + monat + '.' + jahr);
            }

            Belplan.selectAbreise(elem, tag, monat, jahr);
            Belplan.updateBuchung(("0" + anreisedatum.getDate()).slice(-2) + '.' + ("0" + (anreisedatum.getMonth() + 1)).slice(-2) + '.' + anreisedatum.getFullYear(), ("0" + abreisedatum.getDate()).slice(-2) + '.' + ("0" + (abreisedatum.getMonth() + 1)).slice(-2) + '.' + abreisedatum.getFullYear());

            waehleAnreise = !0;
        }
    }
};

Belplan.updateBuchung = function (clickedAnreise, clickedAbreise) {
    // Preisrechner
    if($("#ctrl_pabreise").length !== 0)
        $('#ctrl_pabreise').request('onCalAbreiseChange');

    // Buchungsmaske
    if ($("#ctrl_abreise").length !== 0) {
        $('#ctrl_anreise').request('onAnreiseChange');
        $('#ctrl_abreise').request('onAbreiseChange');
    }

    if ($('#period').length !== 0)
        $('#period').data('dateRangePicker').setDateRange(clickedAnreise, clickedAbreise, true);
    else if ($('#ctrl_panreise').length !== 0)
        $('#ctrl_panreise').data('dateRangePicker').setDateRange(clickedAnreise, clickedAbreise, true);

    if ($('#period').length !== 0)
        $('#period').data('dateRangePicker').setDateRange(clickedAnreise, clickedAbreise, true);
    else if ($('#ctrl_anreise').length !== 0)
        $('#ctrl_anreise').data('dateRangePicker').setDateRange(clickedAnreise, clickedAbreise, true);
};

Belplan.selectAbreise = function (elem, tag, monat, jahr) {
    var tagid = $('#tag_' + jahr + monat + tag);

    if (tagid.length !== 0) {
        var dayEleme, abreiseIndex, diff;
        dayEleme = $('.tag');
        abreiseIndex = dayEleme.index(tagid);
        diff = Belplan.dateDiff(anreisedatum, abreisedatum);

        for (diff; diff > 0; --diff) {
            if (abreiseIndex - diff >= 0)
                dayEleme.eq(abreiseIndex - diff).addClass('gewaehlt');
        }
    }
};

Belplan.selectDatesFromDatepicker = function(anreise, abreise) {
    var dayEleme, tagAn, monatAn, jahrAn, tagAb, monatAb, jahrAb, tagid, clickedAnreise, clickedAbreise, abreiseIndex, diff;

    Belplan.resetBelplan();

    dayEleme = $('.tag');
    tagAn = anreise.substr(0, 2);
    monatAn = anreise.substr(3, 2);
    jahrAn = anreise.substr(6, 4);
    tagAb = abreise.substr(0, 2);
    monatAb = abreise.substr(3, 2);
    jahrAb = abreise.substr(6, 4);
    tagid = $('#tag_' + jahrAb + monatAb + tagAb);
    clickedAnreise = new Date(jahrAn, monatAn - 1, tagAn);
    clickedAbreise = new Date(jahrAb, monatAb - 1, tagAb);
    anreisedatum = clickedAnreise;
    abreisedatum = clickedAbreise;
    abreiseIndex = dayEleme.index(tagid);
    diff = Belplan.dateDiff(clickedAnreise, clickedAbreise);

    for (diff; diff >= 0; diff--) {
        dayEleme.eq(abreiseIndex - diff).addClass('gewaehlt');
    }
};

Belplan.loescheAuswahl = function() {
    $('.nichtwaehlbar').css('pointer-events', 'auto').removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
    $('.gewaehlt').removeClass('gewaehlt');
    $('#period').val(' - ');

    // Preisrechner
    $('#ctrl_panreise').val('');
    $('#ctrl_pabreise').val('');

    // Buchungsmaske
    $('#ctrl_anreise').val('');
    $('#ctrl_abreise').val('');

    $('.shortcuts .delete a').trigger('click');
    anreisedatum = '';
    abreisedatum = '';
    waehleAnreise = !0;
    Belplan.clickEvent();
};

Belplan.resetBelplan = function() {
    $('.nichtwaehlbar').css('pointer-events', 'auto').removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
    $('.gewaehlt').removeClass('gewaehlt');
};

Belplan.dateDiff = function(anreise, abreise) {
    var datediff, tage;
    datediff = abreise.getTime() - anreise.getTime();
    tage = (datediff / (24 * 60 * 60 * 1000));
    tage = Math.round(tage);
    return tage;
};