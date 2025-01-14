$(function() {
    if (script1)
    {
        jQuery("#pbuchung").prop("disabled", false);
        jQuery("#panfrage").prop("disabled", false);
    }

    if (calClick === 1)
        if (anreise !== '')
            Belplan.selectDatesFromDatepicker(anreise, abreise);

    $('#cleardates').click(function(evt) {
        evt.stopPropagation();
        $('#ctrl_panreise').data('dateRangePicker').clear();
    });

    if (datecompact === 1)
    {
        var elemId = $('.fewo-preisrechner .search-anreise').attr('id');
        var dateComponent = '#' + elemId;

        if (!anreise && !abreise)
            $(dateComponent).val(zeitraum);
    }
    else
        var dateComponent = '#ctrl_panreise';

    var picker = $(dateComponent).dateRangePicker({
        separator: separator,
        selectForward: selectForward,
        autoClose: autoClose,
        showArrow: showArrow,
        format: format + ' HH:mm:ss',
        startOfWeek: startOfWeek,
        startDate: startDate,
        minDays: minDays,
        endDate: endDate,
        showShortcuts: showShortcuts,
        shortcuts: shortcuts,
        showLegend: showLegend,
        saisons: saisons,
        blocked: blocked,
        posright: posright,
        language: language,
        showTopbar: showTopbar,
        todayInvalid: todayInvalid,
        customArrowPrevSymbol: customArrowPrev,
        customArrowNextSymbol: customArrowNext,
        wechselleiste: wechselleiste,
        wechselleisteStart: wechselleisteStart,
        legendHtml: (typeof legendHtml === 'undefined' ? '' : legendHtml),
        tooltipMobile: (typeof tooltipMobile === 'undefined' ? false : tooltipMobile),
        beforeShowDay: function(t) {
            valid = this.blocked[0].indexOf(moment(t).format('YYYY-MM-DD'), 0) <= -1;
            var _class = '';
            var _tooltip = valid ? '' : 'belegt';
            return [valid, _class, _tooltip];
        }
    });

    picker.bind('datepicker-change', function (event, obj) {
        $('#ctrl_panreise').val(moment(obj.date1).format('DD.MM.YYYY'));
        $('#ctrl_pabreise').val(moment(obj.date2).format('DD.MM.YYYY'));

        if (datecompact === 1)
        {
            var elemId = $('.fewo-preisrechner .search-anreise').attr('id');
            $('#' + elemId).val(moment(obj.date1).format('DD.MM.YYYY') + " - " + moment(obj.date2).format('DD.MM.YYYY'));
        }

        if (tagein)
        {
            var a = moment(obj.date2,"DD.MM.YYYY");
            var b = moment(obj.date1,"DD.MM.YYYY");
            var tage = a.diff(b, 'days');   // =1
            var selectText ='';
            $('#tagein').find('option').remove().end();
            filterTage(tage);
            $('select[name="tagein"]').val(tage);
        }

        $('#ctrl_pabreise').request('onCalAbreiseChange');

        resetpage = true;
    });

    if (anreise && abreise) {
        $(dateComponent).data('dateRangePicker').setDateRange(anreise, abreise, true);
        $('#ctrl_pabreise').request('onCalAbreiseChange');
    }

    picker.bind('datepicker-clear', function() {
        if (datecompact === 1)
            $('#period').val('');

        $('#ctrl_panreise').val('');
        $('#ctrl_pabreise').val('');
        $('#pbuchung').prop('disabled', true);
        $('#panfrage').prop('disabled', true);

        if (calClick === 1)
            Belplan.resetBelplan();

        $.request('onDeleteDate');
    });
});

$( "#ctrl_pabreise" ).click(function(evt) {
    evt.stopPropagation();
    $('#ctrl_panreise').data('dateRangePicker').open();
});