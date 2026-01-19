let wechselTimeline = wechselleisteBelplan;
let verfuegbarTimeline = verfuegbarleisteBelplan;
let mintageTimeline = mintageleisteBelplan;
let waehleAnreise = !0;
let anreisedatum, abreisedatum;
let anreiseId, abreiseId;
let gewaehlterMonatID = 0;
let verfuegbarleistePrevMonth = null;
let minTageTimelinePrevMonth = null;
let anreiseIndex = 0;
let anreiseMinDays = 1;

$(document).ready(function() {
    InitialisiereKalender();
});

function InitialisiereKalender() {
    $('.ctrlSaisonSelect').on('change', Belplan.calSelect);
    $('.ctrlCalNext').on('click', Belplan.calRight);
    $('.ctrlCalPrev').on('click', Belplan.calLeft);
}

let Belplan = function() {};
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
            let belPlan = resp['#ctrlBookingPlans_' + calid];
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
            caloffset = resp['caloffset'];
            Belplan.updateCal();
        }
    });
};

Belplan.calLeft = function () {
    $.request('onBtnLeft', {
        method: 'post',
        data: {'caloffset' : caloffset, 'calid' : calid},
        success: function(resp) {
            let belPlan = resp['#ctrlBookingPlans_' + calid];
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
            caloffset = resp['caloffset'];
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
            let belPlan = resp['#ctrlBookingPlans_' + calid];
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
    let tag, monat, jahr, elem;

    if (anreisedatum && !abreisedatum) {
        let anreiseElem, arrAnreise, dayEleme, day, wechselStatus, verfuegbarStatus;

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
        let abreiseElem, arrAbreise;

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
    let dayEleme = $('.tag:not(.nichtselektierbar)');
    if (waehleAnreise) {
        Belplan.addNichtWaehlbarClass();
    }

    dayEleme.off('click').off('keypress');
    dayEleme.click(function() {
        Belplan.waehleDatum(this);
    }).keypress(function(e) {
        if (e.which === 13) {
            Belplan.waehleDatum(this);
        }
    });
};

Belplan.addNichtWaehlbarClass = function() {
    // if(!anreisedatum  && !abreisedatum)
    const tage = $('.tag');

    for (let i = 0; i < wechselTimeline.length; i++) {

        const wechselstatus = wechselTimeline.charAt(i);
        const verfuegbarStatus = verfuegbarTimeline.charAt(i);

        if (wechselstatus === 'O') {
            tage.eq(i).addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
        } else if (wechselstatus === 'X' && verfuegbarStatus === 'Y') {
            tage.eq(i).addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
        } else if (wechselstatus === 'X' && verfuegbarStatus === 'N' && wechselTimeline.charAt(i - 1) === 'X' && verfuegbarTimeline.charAt(i - 1) === 'Y') {
            tage.eq(i).addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
        }
    }
};

function anreiseClicked(elem, wechselStatus, verfuegbarStatus, hasClicked = false) {
    if (hasClicked === false) {
        if (wechselStatus === 'C' || wechselStatus === 'I' && wechselStatus !== 'O' && verfuegbarStatus === 'Y') {
            let dayEleme, dateId, tag, monat, jahr, dayId, mintage;
            anreiseMinDays = $(elem).attr('data-xs-mindays');
            dayEleme = $('.tag');
            dateId = $(elem).attr('id');
            tag = dateId.substr(10, 2);
            monat = dateId.substr(8, 2);
            jahr = dateId.substr(4, 4);
            dayId = dayEleme.index(elem);
            anreiseIndex = dayId;
            let mintageArr = mintageTimeline.split(';');
            mintage = mintageArr[dayId];
            anreisedatum = new Date(jahr + '-' + monat + '-' + tag);
            anreiseId = dayId;
            dayEleme.removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
            dayEleme.slice(0, dayId).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
            dayEleme.slice(dayId).css('pointer-events', '').removeClass('nichtwaehlbar').removeClass('nichtselektierbar').removeClass('keineanabreise').removeClass('fehleranreisetag').addClass('waehlbar').attr('tabindex', '0');
            $(elem).addClass('gewaehlt');
            $('#period').val(tag + '.' + monat + '.' + jahr + ' - ');
            $('#ctrl_panreise').val(tag + '.' + monat + '.' + jahr);
            $('#ctrl_anreise').val(tag + '.' + monat + '.' + jahr);

            let verfuegbarZeitraumAbSelektierterTag = verfuegbarTimeline.substring(anreiseId, dayEleme.index(dayEleme.last()));
            let wechselZeitraumAbSelektierterTag = wechselTimeline.substring(anreiseId, dayEleme.index(dayEleme.last()));

            // Suche erste Belegung ab Selektierter Tag und setze alles dahinter auf nichtselektierbar/nichtwaehlbar
            if (verfuegbarZeitraumAbSelektierterTag.includes('N')) {
                let nextBelId = anreiseId + verfuegbarZeitraumAbSelektierterTag.indexOf('N') + 1;
                dayEleme.slice(dayId, nextBelId).removeClass('nichtwaehlbar').removeClass('nichtselektierbar').attr('tabindex', '0');
                dayEleme.slice(nextBelId).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
            }

            // Setze alles was ab Selektierter Tag X oder I ist auf nichtselektierbar/nichtwaehlbar da weder Anreise noch Abreise möglich ist
            for (let i = 0; i < wechselZeitraumAbSelektierterTag.length; i++) {
                let currentDayId = anreiseId + i + 1;
                if (wechselTimeline.charAt(currentDayId) === 'X' || wechselTimeline.charAt(currentDayId) === 'I')
                    dayEleme.slice(currentDayId, currentDayId + 1).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
            }

            let mintageRange = wechselTimeline.substr(dayId, parseInt(mintage) + 1);

            if ($(elem).hasClass('lbok')) {
                if (mintageRange.includes('O')) {
                    mintage = mintageRange.lastIndexOf('O');
                }
            }

            for (let i = 0; i < mintage; i++) {
                let mintageStatus = wechselTimeline.charAt(dayId + i);

                if (i < mintage) {
                    dayEleme.eq(dayId + i).addClass('nichtwaehlbar').addClass('nichtselektierbar').css('pointer-events', 'none').attr('tabindex', '-1');
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
            Belplan.hoverEvent();
        }
    } else {
        let dayEleme2 = $('.tag');

        if ($(elem).length) {
            let dayId2, mintage2, verfuegbarZeitraum2;

            $(elem).addClass('gewaehlt');
            dayId2 = dayEleme2.index(elem);
            let mintage2Arr = mintageTimeline.split(';');
            mintage2 = mintage2Arr[dayId2];
            verfuegbarZeitraum2 = verfuegbarTimeline.substring(dayId2);
            dayEleme2.slice(0, dayId2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');

            if (verfuegbarZeitraum2.includes('N')) {
                let nextBelId2 = dayId2 + verfuegbarZeitraum2.indexOf('N') + 1;
                dayEleme2.slice(dayId2, nextBelId2).removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
                dayEleme2.slice(nextBelId2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
            }

            let mintageRange2 = wechselTimeline.substr(dayId2, parseInt(mintage2) + 1);

            if (mintageRange2.includes('X')) {
                for (let i2 = 0; i2 < mintage2; i2++) {
                    const mintageStatus2 = wechselTimeline.charAt(dayId2 + i2);

                    if (mintageStatus2 !== 'O') {
                        dayEleme2.eq(dayId2 + i2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
                    }
                }
            } else {
                for (let j2 = 0; j2 < mintage2; j2++) {
                    dayEleme2.eq(dayId2 + j2).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
                }
            }
        } else {
            let preMonthOffset, preMonthTimeline, firstBelId, mintageFromAnreise;
            preMonthOffset = verfuegbarleistePrevMonth.length - verfuegbarTimeline.length;
            preMonthTimeline = verfuegbarleistePrevMonth.substring(anreiseId, preMonthOffset);
            firstBelId = verfuegbarTimeline.indexOf('N') + 1;
            let mintagePrevMonthArr = minTageTimelinePrevMonth.split(';');
            mintageFromAnreise = mintagePrevMonthArr[anreiseId];
            dayEleme2.slice(firstBelId).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');

            if ((preMonthOffset - anreiseId) < mintageFromAnreise)
                dayEleme2.slice(0, mintageFromAnreise - (preMonthOffset - anreiseId)).css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');

            if (preMonthTimeline.includes('N'))
                dayEleme2.slice().css('pointer-events', 'none').addClass('nichtwaehlbar').addClass('nichtselektierbar').attr('tabindex', '-1');
        }

        waehleAnreise = !1;
        Belplan.clickEvent();
        Belplan.hoverEvent();
    }
};

function abreiseClicked(elem, wechselStatus) {
    if (wechselStatus === 'C' || wechselStatus === 'O' && wechselStatus !== 'I' && wechselStatus !== 'X' || ($(elem).hasClass('waehlbar') && !$(elem).hasClass('nichtwaehlbar') && !$(elem).hasClass('gewaehlt'))) {
        let dateId, tag, monat, jahr;
        $(elem).addClass('gewaehlt');
        $('.nichtwaehlbar').css('pointer-events', 'none').removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
        dateId = $(elem).attr('id');
        tag = dateId.substr(10, 2);
        monat = dateId.substr(8, 2);
        jahr = dateId.substr(4, 4);
        abreisedatum = new Date(jahr + '-' + monat + '-' + tag);

        // Preisrechner
        if($("#ctrl_pabreise").length !== 0)
        {
            let panreise = $('#ctrl_panreise').val();
            $('#period').val(panreise + ' - ' + tag + '.' + monat + '.' + jahr);
            $('#ctrl_pabreise').val(tag + '.' + monat + '.' + jahr);
        }

        // Buchungsmaske
        if ($("#ctrl_abreise").length !== 0)
        {
            let buanreise = $('#ctrl_anreise').val();
            $('#period').val(buanreise + ' - ' + tag + '.' + monat + '.' + jahr);
            $('#ctrl_abreise').val(tag + '.' + monat + '.' + jahr);
        }

        let anreise = ("0" + anreisedatum.getDate()).slice(-2) + '.' + ("0" + (anreisedatum.getMonth() + 1)).slice(-2) + '.' + anreisedatum.getFullYear()
        let abreise = ("0" + abreisedatum.getDate()).slice(-2) + '.' + ("0" + (abreisedatum.getMonth() + 1)).slice(-2) + '.' + abreisedatum.getFullYear()

        Belplan.selectAbreise(elem, tag, monat, jahr);
        Belplan.updateBuchung(anreise, abreise);

        waehleAnreise = !0;
    }
}

Belplan.waehleDatum = function (elem) {
    let dayEleme, day, wechselStatus, verfuegbarStatus;
    dayEleme = $('.tag');
    day = dayEleme.index(elem);
    wechselStatus = wechselTimeline.charAt(day);
    verfuegbarStatus = verfuegbarTimeline.charAt(day);

    if (waehleAnreise) {
        Belplan.loescheAuswahl(false);
        anreiseClicked(elem, wechselStatus, verfuegbarStatus);
    } else {
        abreiseClicked(elem, wechselStatus);
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
    else if ($('#ctrl_anreise').length !== 0)
        $('#ctrl_anreise').data('dateRangePicker').setDateRange(clickedAnreise, clickedAbreise, true);

    if (typeof datePickerChanged === "function") {
        datePickerChanged();
    }
};

Belplan.selectAbreise = function (elem, tag, monat, jahr) {
    let tagid = $('#tag_' + jahr + monat + tag);

    if (tagid.length !== 0) {
        let dayEleme, abreiseIndex, diff;
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
    let dayEleme, tagAn, monatAn, jahrAn, tagAb, monatAb, jahrAb, tagid, clickedAnreise, clickedAbreise, abreiseIndex, diff;

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

Belplan.setBelplanOffset = function (calid, offset) {
    $.request('onSelectorChange', {
        method: 'post',
        data: {'calSelector' : offset, 'calid' : calid},
        success: function(resp) {
            let belPlan = resp['#ctrlBookingPlans_' + calid];
            $('.fewo_buchungsplan').html(belPlan);
            caloffset = offset;

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

Belplan.loescheAuswahl = function(deleteAll = true) {
    $('.tag').unbind("mouseenter").unbind("mouseleave");
    Belplan.resetBelplan();
    $('.waehlbar').css('pointer-events', 'all');
    $('#period').val(' - ');

    // Preisrechner
    $('#ctrl_panreise').val('');
    $('#ctrl_pabreise').val('');

    // Buchungsmaske
    $('#ctrl_anreise').val('');
    $('#ctrl_abreise').val('');

    if (deleteAll) {
        // Preisrechner
        $('#ctrl_ppersonen').val(1);
        $('#pbuchung').prop('disabled', true);
        $('#panfrage').prop('disabled', true);

        // Buchungsmaske
        $('#ctrl_erwachsene').val(1);
        $('#ctrl_kinder').val(0);
        $('#ctrl_kleinkinder').val(0);
    }

    $('.shortcuts .delete a').trigger('click');
    anreisedatum = '';
    abreisedatum = '';
    waehleAnreise = !0;
    Belplan.clickEvent();
};

Belplan.resetBelplan = function() {
    $('.nichtwaehlbar').css('pointer-events', 'none').removeClass('nichtwaehlbar').removeClass('nichtselektierbar');
    $('.frei.waehlbar').css('pointer-events', 'auto');
    $('.gewaehlt').removeClass('gewaehlt');
    Belplan.clickEvent();
};

Belplan.dateDiff = function(anreise, abreise) {
    let datediff, tage;
    datediff = abreise.getTime() - anreise.getTime();
    tage = (datediff / (24 * 60 * 60 * 1000));
    tage = Math.round(tage);
    return tage;
};

Belplan.hoverEvent = function () {
    if (waehleAnreise === false) {
        $('.gewaehlt').mouseenter(function () {
            $('.belplan-tooltip').remove();
            $(this).css('position', 'relative').append(getTooltipContainer(anreiseMinDays, $(this).attr('data-xs-title')));
        }).mouseleave(function() {
            $('.belplan-tooltip').remove();
            $(this).css('position', '');
        });
    }

    $('.nichtwaehlbar').on('click', function() {
        let clickedIndex = $('.tag').index(this);

        if (clickedIndex > anreiseIndex) {
            $('.belplan-tooltip').remove();
            $(this).addClass('tooltipOpen').append(getTooltipContainer(anreiseMinDays, $(this).attr('data-xs-title')));
        }
    }).on('mouseleave', function() {
        $('.belplan-tooltip').remove();
        $(this).removeClass('tooltipOpen');
    });
}

function getTooltipContainer(mindays, date) {
    let toolTipText = 'Minimum [n] Nächte buchen';

    if (typeof mindaysText !== 'undefined')
        toolTipText = mindaysText;

    toolTipText = toolTipText.replace('[n]', mindays);
    toolTipText = toolTipText.replace('[date]', date);

    return '<div class="belplan-tooltip">' + toolTipText + '</div>';
}