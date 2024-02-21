$(function() {
    $(".wpwl-button").click(function() {
        alert("hallo");
    });

    if (calClick === 1 && typeof Belplan === 'function')
    {
        if (anreise !== '')
            Belplan.selectDatesFromDatepicker(anreise, abreise);
    }

    if (datecompact === 1)
    {
        if (anreise !== '')
            $('#period').val(anreise + ' - ' + abreise);
    }

    if (datecompact === 1)
        var dateComponent = '#period';
    else
        var dateComponent = '#ctrl_anreise';

    var picker = $(dateComponent).dateRangePicker({
        separator: separator,
        selectForward: selectForward,
        autoClose: autoClose,
        format: format + ' HH:mm:ss',
        alwaysOpen: alwaysOpen,
        showShortcuts: showShortcuts,
        showLegend: showLegend,
        shortcuts: shortcuts,
        startOfWeek: startOfWeek,
        startDate: startDate,
        minDays: minDays,
        endDate: endDate,
        saisons: saisons,
        blocked: blocked,
        language: language,
        showTopbar: showTopbar,
        todayInvalid: todayInvalid,
        customArrowPrevSymbol: customArrowPrev,
        customArrowNextSymbol: customArrowNext,
        wechselleiste: wechselleiste,
        wechselleisteStart: wechselleisteStart,
        legendHtml: (typeof legendHtml === 'undefined' ? '' : legendHtml),
        tooltipMobile: (typeof tooltipMobile === 'undefined' ? false : tooltipMobile),
        beforeShowDay: function(t)
        {
            valid = this.blocked[0].indexOf(moment(t).format('YYYY-MM-DD'), 0) <= -1;
            var _class = '';
            var _tooltip = valid ? '' : 'belegt';
            return [valid, _class, _tooltip];
        },
    });

    if (datecompact === 1)
        $('#period').attr("placeholder", dateplaceholder);

    picker.bind('datepicker-first-date-selected', function(event, obj) {
        $('#ctrl_anreise').val(moment(obj.date1).format('DD.MM.YYYY'));
        $('#ctrl_anreise').request('onAnreiseChange');
    });

    picker.bind('datepicker-clear', function() {
        if (datecompact === 1)
            $('#period').val('');

        $('#ctrl_anreise').val('');
        $('#ctrl_abreise').val('');

        if (calClick === 1 && typeof Belplan === 'function')
            Belplan.resetBelplan();
    });

    picker.bind('datepicker-change', function(event, obj) {
        $('#ctrl_anreise').val(moment(obj.date1).format('DD.MM.YYYY'));
        $('#ctrl_abreise').val(moment(obj.date2).format('DD.MM.YYYY'));
        $('#ctrl_anreise').request('onAnreiseChange');
        $('#ctrl_abreise').request('onAbreiseChange');

        if (datecompact === 1)
            $('#period').val(moment(obj.date1).format('DD.MM.YYYY') + " - " + moment(obj.date2).format('DD.MM.YYYY'));

        if (typeof datePickerChanged === "function") {
            datePickerChanged();
        }
    });

    if (anreise && abreise)
    {
        $('#ctrl_erwachsene').val(perwachsene);
        $('#ctrl_kinder').val(pkinder);
        $(dateComponent).data('dateRangePicker').setDateRange(anreise, abreise, true);
        $('#ctrl_abreise').request('onAbreiseChange');
    }
});

$( "#ctrl_abreise" ).click(function(evt) {
    evt.stopPropagation();
    $('#ctrl_anreise').data('dateRangePicker').open();
});