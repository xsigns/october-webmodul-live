const { exportFile, useQuasar } = Quasar
const { ref } = Vue

/*---------------------------------------------------*/
/* Columns */
const columnsRechnung = [
    { name: 'rechnungsnr', sortOrder: 'ad', align: 'left', label: rechnungsnr, field: 'rechnr', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
    { name: 'von', align: 'left', label: von, field: 'von', sortable: true, sort: (a, b) => sortDatum(a, b)},
    { name: 'to', align: 'left', label: bis, field: 'to', sortable: true, sort: (a, b) => sortDatum(a, b)},
    { name: 'datum', align: 'left', label: abrZeitraum, field: 'datum', sortable: true, sort: (a, b) => sortDatum(a, b)},
    { name: 'betrag', align: 'right', label: betrag, field: 'betrag', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
    { name: 'art', label: 'Downloads', align: 'center',field: 'art'},
]

const columnsRechnung2 = [
    { name: 'abr', align: 'center', label: 'Abrechnung', field: 'abr' },
    { name: 'prov', align: 'center', label: 'Provision', field: 'prov' },
    { name: 'wartung1', align: 'center', label: 'Wartung 1', field: 'wartung1' },
    { name: 'wartung2', align: 'center', label: 'Wartung 2', field: 'wartung2' },
    { name: 'wartung3', align: 'center', label: 'Wartung 3', field: 'wartung3' },
    { name: 'wartung4', align: 'center', label: 'Wartung 4', field: 'wartung4' },
]

const columns = [
    { name: 'id', align: 'left', label: id, field: 'id', sortable: true, sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
    { name: 'datum', align: 'left', label: buchungsdatum, field: 'datum', sortable: true, sort: (a, b) => sortDatum(a, b)},
    { name: 'art', align: 'left', label: art, field: 'art', sortable: true},
    { name: 'anreise', align: 'left', label: anreise, field: 'anreise', sortable: true, sort: (a, b) => sortDatum(a, b)},
    { name: 'abreise', align: 'left', label: abreise, field: 'abreise', sortable: true, sort: (a, b) => sortDatum(a, b)},
    { name: 'tage', align: 'left', label: tage, field: 'tage', sortable: true},
    { name: 'objekt', align: 'left', label: objekt, field: 'objekt', sortable: true,},
    { name: 'objid', align: 'left', label: objid, field: 'objid', sortable: true},
    { name: 'erwachsene', align: 'left', label: erwachsene, field: 'erwachsene', sortable: true},
    { name: 'kinder', align: 'left', label: kinder, field: 'kinder', sortable: true},
    { name: 'objpreis', align: 'right', label: summe, field: 'objpreis', sortable: true,  sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
]

function sortDatum(a, b) {
    const datePartsA = moment(a, 'DD.MM.YYYY').toDate();
    const datePartsB = moment(b, 'DD.MM.YYYY').toDate();

    if (datePartsA && datePartsB) {
        const dateA = new Date(datePartsA);
        const dateB = new Date(datePartsB);

        return dateA - dateB;
    } else {
        return 0;
    }
}
const columnsGastVisableColumns = []

if (showGastVorname == 1)
    columnsGastVisableColumns.push({ name: 'vorname', align: 'left', label: vorname, field: 'vorname'});

if (showGastName == 1)
    columnsGastVisableColumns.push({ name: 'name', align: 'left', label: nachname, field: 'name'});

if (showGastMail == 1)
    columnsGastVisableColumns.push({ name: 'mail', align: 'left', label: mail, field: 'mail'});

if (showGastTel == 1)
    columnsGastVisableColumns.push({ name: 'tel', align: 'left', label: telefon, field: 'tel'});

if (showOrt == 1)
    columnsGastVisableColumns.push({ name: 'ort', align: 'left', label: ort, field: 'ort'});

if (showPlz == 1)
    columnsGastVisableColumns.push({ name: 'plz', align: 'left', label: plz, field: 'plz'});

if (showStrasse == 1)
    columnsGastVisableColumns.push({ name: 'strasse', align: 'left', label: strasse, field: 'strasse'});

if (showLand == 1)
    columnsGastVisableColumns.push({ name: 'land', align: 'left', label: land, field: 'land'});

if (showMobil == 1)
    columnsGastVisableColumns.push({ name: 'mobil', align: 'left', label: mobil, field: 'mobil'});

if (showGastHinweis == 1)
    columnsGastVisableColumns.push({ name: 'memo', align: 'left', label: memo, field: 'memo'});

if (showGastEigentuemerhinweis == 1)
    columnsGastVisableColumns.push({ name: 'ehinweis', align: 'left', label: ehinweis, field: 'ehinweis'});


const columnsGast = columnsGastVisableColumns;
const columnsLeist = [
    { name: 'nr', align: 'left', label: lnr, field: 'nr',  sortable: true },
    { name: 'anz', align: 'left', required: true, label: ltitel, field: 'anz', sortable: true},
    { name: 'text', align: 'left', label: lanz, field: 'text',  sortable: true },
    { name: 'epreis', align: 'right', label: lepreis, field: 'epreis',  sortable: true },
    { name: 'summe', align: 'right', label: lsumme, field: 'summe', sortable: true },
]

const columnsGesammt = [
    { name: 'id', align: 'left', label: '', field: 'id',},
    { name: 'jahr', align: 'left', required: true, label: '',field: row => row.jahr,format: val => `${val}`},
    { name: 'datum', align: 'left', label: '', field: 'datum', sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
    { name: 'art', align: 'left', label: '', field: 'art'},
    { name: 'anreise', align: 'left', label: '', field: 'anreise', sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
    { name: 'abreise', align: 'left', label: '', field: 'abreise', sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
    { name: 'tage', align: 'left', label: '{{ labels.vorgtage }}', field: 'tage', sortable: true,  sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
    { name: 'objekt', align: 'left', label: '', field: 'objekt'},
    { name: 'objid', align: 'left', label: '', field: 'objid'},
    { name: 'erwachsene', align: 'left', label: '{{ labels.vorgerwachsene }}', field: 'erwachsene', sortable: true,  sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
    { name: 'kinder', align: 'left', label: '', field: 'kinder'},
    { name: 'objpreis', align: 'right', label: '', field: 'objpreis'},
]

const columnsObjekte = [
    { name: 'nr', align: 'left', label: objnr, field: 'id', sortable: true,  sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
    { name: 'objekt', align: 'left', label: objtitel, field: 'titel', sortable: true},
    { name: 'pers', align: 'left', label: objpers, field: 'pers', sortable: true,  sort: (a, b) => parseInt(a, 10) - parseInt(b, 10)},
    { name: 'qm', align: 'left', label: objqm, field: 'qm', sortable: true,  sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
    { name: 'intern', align: 'left', label: objint, field: 'intern', sortable: true,  sort: (a, b) => parseInt(a, 10) - parseInt(b, 10) },
]

const rowsRechnung2 = abrechnungen
const rows2 =  vorgaenge
const rowsObjekte2 = objekte

var selectCheckboxDownload = []

/*---------------------------------------------------*/
/* Formatierung vom Datum */

for (let i = 0; i < rowsObjekte2.length; i++)
    rowsObjekte2[i]['qm'] = rowsObjekte2[i]['qm'].replace('.', ',')


for (let i = 0; i < rowsRechnung2.length; i++)
    rowsRechnung2[i]['betrag'] = rowsRechnung2[i]['betrag'].replace('.', ',') + ' €'


var gesArrayDown = []

for (let i = 0; i < rows2.length; i++)
{
    var date = rows2[i]['datum']
    jahr = date.substring(0,4)
    monat = date.substring(7,5)
    day = date.substring(8,10)
    rows2[i]['datum'] = day + '.' + monat + '.' + jahr

    var date = rows2[i]['anreise']
    jahr = date.substring(0,4)
    monat = date.substring(7,5)
    day = date.substring(8,10)
    rows2[i]['anreise'] = day + '.' + monat + '.' + jahr

    var date = rows2[i]['abreise']
    jahr = date.substring(0,4)
    monat = date.substring(7,5)
    day = date.substring(8,10)
    rows2[i]['abreise'] = day + '.' + monat + '.' + jahr

    rows2[i]['objpreis'] = rows2[i]['objpreis'].replace('.', ',')
}

/*---------------------------------------------------*/

/*---------------------------------------------------*/
/* Vorgänge Filter Werte sezten */

var arrayRechId = []
for (let i = 0; i < rowsRechnung2.length; i++)
    arrayRechId.push(rowsRechnung2[i]['rechnr'])


arrayRechId.sort(function(a, b){return b-a})

var arrayDatum = []
var arrayAnReise = []
var arrayAbReise = []
var arrayJahr = []
var arrayObNummer = []
var arrayArt = []
var arrayId = []
var arrayObj = []

for (let i = 0; i < rows2.length; i++)
{
    arrayDatum.push(rows2[i]['datum'].split('.').reverse().join('/'))
    arrayAnReise.push(rows2[i]['anreise'].split('.').reverse().join('/'))
    arrayAbReise.push(rows2[i]['anreise'].split('.').reverse().join('/'))
    arrayAbReise.push(rows2[i]['abreise'].split('.').reverse().join('/'))

    if (jQuery.inArray(rows2[i]['jahr'], arrayJahr) === -1)
        arrayJahr.push(rows2[i]['jahr'])

    if (jQuery.inArray(rows2[i]['objid'], arrayObNummer) === -1)
        arrayObNummer.push(rows2[i]['objid'])

    if (jQuery.inArray(rows2[i]['art'], arrayArt) === -1)
        arrayArt.push(rows2[i]['art'])

    if (jQuery.inArray(rows2[i]['id'], arrayId) === -1)
        arrayId.push(rows2[i]['id'])

    if (jQuery.inArray(rows2[i]['objekt'], arrayObj) === -1)
        arrayObj.push(rows2[i]['objekt'])
}

arrayId.sort(function(a, b){return b-a})
arrayObNummer.sort(function(a, b){return b-a})
arrayJahr.sort(function(a, b){return b-a})
arrayObj.sort()

/*---------------------------------------------------*/

/*---------------------------------------------------*/
/* Objekt Filter Werte sezten */

var arrayObjNummer = []
for (let i = 0; i < rowsObjekte2.length; i++) {
    if (jQuery.inArray(rowsObjekte2[i]['id'], arrayObjNummer) === -1) {
        arrayObjNummer.push(rowsObjekte2[i]['id'])
    }
}

var arrayObjName = []
var arrayObjIntern = []
var arrayObjPersonen = []
var arrayObjGroesse = []

for (let i = 0; i < rowsObjekte2.length; i++)
{
    if (jQuery.inArray(rowsObjekte2[i]['titel'], arrayObjName) === -1)
        arrayObjName.push(rowsObjekte2[i]['titel'])

    if (jQuery.inArray(rowsObjekte2[i]['intern'], arrayObjIntern) === -1)
        arrayObjIntern.push(rowsObjekte2[i]['intern'])

    if (jQuery.inArray(rowsObjekte2[i]['pers'], arrayObjPersonen) === -1)
        arrayObjPersonen.push(rowsObjekte2[i]['pers'])

    if (jQuery.inArray(rowsObjekte2[i]['qm'], arrayObjGroesse) === -1)
        arrayObjGroesse.push(rowsObjekte2[i]['qm'].replace('.', ','))
}

arrayObjName.sort()
arrayObjIntern.sort()
arrayObjPersonen.sort(function(a, b){return a-b})
arrayObjGroesse.sort(function(a, b){return a-b})

/*---------------------------------------------------*/

/*---------------------------------------------------*/
/* Rechnungen Filter Werte sezten */

var arrayRechVon = []
var arrayRechBis = []
var arrayRechDate = []
for (let i = 0; i < rowsRechnung2.length; i++)
{
    arrayRechVon.push(rowsRechnung2[i]['von'].split('-').join('/'))
    arrayRechBis.push(rowsRechnung2[i]['to'].split('-').join('/'))
    arrayRechBis.push(rowsRechnung2[i]['von'].split('-').join('/'))
    arrayRechDate.push(rowsRechnung2[i]['datum'].split('-').join('/'))
}

for (var i = 0; i < rowsRechnung2.length; i++)
{
    var date = rowsRechnung2[i]['datum']
    jahr = date.substring(0,4)
    monat = date.substring(7,5)
    day = date.substring(8,10)
    rowsRechnung2[i]['datum'] = day + '.' + monat + '.' + jahr

    var date = rowsRechnung2[i]['von']
    jahr = date.substring(0,4)
    monat = date.substring(7,5)
    day = date.substring(8,10)
    rowsRechnung2[i]['von'] = day + '.' + monat + '.' + jahr

    var date = rowsRechnung2[i]['to']
    jahr = date.substring(0,4)
    monat = date.substring(7,5)
    day = date.substring(8,10)
    rowsRechnung2[i]['to'] = day + '.' + monat + '.' + jahr
}
var checkName = []
for (let i = 0; i < rowsRechnung2.length; i++)
{
    checkName.push(rowsRechnung2[i]['rechnr'])
}
/*---------------------------------------------------*/
/*---------------------------------------------------*/

function wrapCsvValue (val, formatFn, row)
{
    let formatted = formatFn !== void 0
        ? formatFn(val, row)
        : val

    formatted = formatted === void 0 || formatted === null
        ? ''
        : String(formatted)

    formatted = formatted.split('"').join('""')

    return `"${formatted}"`
}

const stringOptions = objekte2

const app = Vue.createApp({
    delimiters: ['[[', ']]'],
    setup ()
    {
        const rows = ref([...rows2])
        const rowsRechnung = ref([...rowsRechnung2])
        const rowsObjekte = ref([...rowsObjekte2])
        const options = ref(stringOptions)
        const loading = ref(false)
        const loadingObjekte = ref(false)
        const loadingRech = ref(false)
        const selected = ref([])
        const downloadSelect = ref(gesArrayDown)
        const $q = useQuasar()
        const progess = ref(false)
        const val = ref([])
        const a64 = ref(false)

        const datumVonBis = ref('')
        const abrDatum = ref('')
        const datumVonBisVorg = ref('')
        const vorgDatum = ref('')
        const objektNr = ref('')
        const objektName = ref('')
        const obj = ref('')
        const objid = ref('')
        const filterArtAbrModel = ref('');

        const mailSendInputCC = ref('')
        const mailSendInputBesch = ref(sendMailDefaulReferenceValue)
        const mailSendInput = ref(mailaddressUser)
        const messageValue = ref()

        return {
            test()
            {
                dialog = true
            },

            Label_ID: 'ID',
            Label_Jahr: 'Jahr',
            Label_Datum: 'Datum',
            Label_Art: 'Art',
            Label_Anreise: 'Anreise',
            Label_Abreise: 'Abreise',
            Label_Tage: 'Tage',
            Label_Objekt: 'Objekt',
            Label_ObjektId: 'Objekt-ID',
            Label_Erw: 'Erw.',
            Label_Kind: 'Kind',
            Label_Preis: 'Obj-Preis',

            cancelEnabled: ref(true),
            expanded: ref(false),

            getArt(props)
            {
                if (props.row.art === 'B')
                    return 'fred'
                if (props.row.art === 'BL')
                    return 'fgreen'
                if (props.row.art === 'O' || props.row.art === 'E')
                    return 'fblack'
                if (props.row.art === 'A')
                    return 'fyellow'
                return ''
            },
            initialPagination:
            {
                page: 1,
                rowsPerPage: anzahl,
                sortBy: 'datum',
                descending: true,
            },
            initialPaginationLeist:
            {
                page: 1,
                rowsPerPage: 1000
            },
            initialPaginationAbrechnungen:
            {
                page: 1,
                rowsPerPage: anzahl,
                sortBy: 'rechnungsnr',
                descending: true,
            },
            /*------------------------------------------*/
            /*------------------------------------------*/

            gastdatebShow(id)
            {
                $('#' + id).removeClass('display-none');
                $('body').addClass('no-scroll2');

                $('.isOpen').text(id)
                //$('.ban').removeClass('display-none')
                $('button[name="' + id + '"]').removeClass('display-none')

                setTimeout(function() {
                    $('.my-card').removeClass('transform');
                }, 1);
            },
            close(id)
            {
                $('.my-card').addClass('transform');
                $('.isOpen').text('')

                setTimeout(function() {
                    $('.ban').addClass('display-none');
                    $('#' + id).addClass('display-none');
                    $('.' + id).addClass('display-none');
                }, 200);
                canScroll()
            },
            /*------------------------------------------*/
            /*------------------------------------------*/
            leistung(id)
            {
                $('.' + id).removeClass('display-none');
                $('body').addClass('no-scroll2');

                $('.isOpen').text(id)
                //$('.ban').removeClass('display-none')
                $('button[name="' + id + '"]').removeClass('display-none')

                setTimeout(function() {
                    $('.my-card').removeClass('transform');
                }, 1);
            },
            /*------------------------------------------*/
            /*------------------------------------------*/

            getTotal()
            {
                setTimeout(function()
                {
                    let sum = 0
                    if ($('.q-td.text-right').length !== 0) {
                        let rows = $('td#objpreis.q-td.text-right')

                        for (let i = 0; i < rows.length; i++)
                            sum += parseFloat(rows[i]['innerHTML'].replace(',', '.').replace(' €', ''));
                    }

                    $('#gesammt1').html(gesammtSumme + ': ' + sum.toFixed(2).replace('.', ',') + ' €')
                }, 1);
            },

            getTotalVorg()
            {
                setTimeout(function()
                {
                    let sum = 0
                    if ($('td.text-right').length !== 0)
                    {
                        let rows = $('td.text-right')

                        for (let i = 0; i < rows.length; i++)
                            sum += parseFloat(rows[i]['innerHTML'].replace(',', '.').replace(' €', ''));
                    }

                    $('#gesammtVorg').html(gesammtSumme + ': ' + sum.toFixed(2).replace('.', ',') + ' €')
                }, 1);
            },

            ChangeRecords() {
                loadRecord()
            },

            filterOnOff(value)
            {
                if (value === false)
                    $('.vorgangFilterBTN').css({display: 'none'})
                else
                    $('.vorgangFilterBTN').css({display: 'flex'})
            },

            filter: ref(''),
            text: ref(''),
            id: ref(''),
            jahr: ref(''),
            datum: ref(''),
            datumAb: ref(''),
            datumAn: ref(''),
            obj: ref(''),
            objid: ref(''),
            preis: ref(''),
            datafilter: ref(true),
            objektNr: ref(),
            dialog: ref(false),
            current: ref(0),
            mailSend: ref(false),
            mailSendInput,
            mailSendInputBesch,
            mailSendInputCC,
            mailSendBTNCheck: true,

            rechSortData: [sortVor, sortBack],

            /* Vorgänge Filter */
            dateOption: arrayDatum,
            dateAnOption: arrayAnReise,
            dateAbOption: arrayAbReise,
            dataJahr: arrayJahr,
            dataObId: arrayObNummer,
            dataArt: arrayArt,
            dataId: arrayId,
            dataObjekt: arrayObj,
            /*-----------*/

            /* Objektliste filter */
            dataNr: arrayObjNummer,
            dataObjektName: arrayObjName,
            dataObjektIntern: arrayObjIntern,
            dataObjektPersonen: arrayObjPersonen,
            dataObjektQm: arrayObjGroesse,
            /*-----------*/

            /*-----------*/
            dataRechID: arrayRechId,
            dataRechVon: arrayRechVon,
            dataRechBis: arrayRechBis,
            dataRechdatum: arrayRechDate,
            filterArtAbr: [anreise, abreise, abUndAbreise, abrZeitraum],
            filterArtVorg: [anreise, abreise, abUndAbreise, buchungsdatum],
            filterArtAbrModel,
            /*-----------*/

            downloadSelect,

            datumS: ref(''),
            tab: ref('Abrechnungen'),

            /*------Tabels------*/
            columnsRechnung,
            columnsRechnung2,
            rowsRechnung,
            columns,
            rows,
            columnsGast,
            columnsLeist,
            columnsGesammt,
            progess,
            columnsObjekte,
            rowsObjekte,
            /*-----------*/
            loading,
            loadingObjekte,
            loadingRech,
            selected,
            model: ref(null),
            stringOptions,
            options,
            selectCheckboxDownload,
            val,
            a64,
            RechSelect: ref(),

            datumVonBis,
            abrDatum,
            datumVonBisVorg,
            vorgDatum,
            objektNr,
            objektName,
            objid,
            obj,
            messageValue,

            modelJahr: ref(null),

            getSelectedString ()
            {
                return selected.value.length === 0 ? '' : `${selected.value.length} Zeile${selected.value.length > 1 ? 'n' : ''} von ${rowsRechnung2.length} ausgewählt`
            },

            scrolltTop(newPagination)
            {
                window.scrollTo(0, 0);
            },

            setAllSelectTrue()
            {
                gesArrayDown = []
                for (let i = 0; i < rowsRechnung2.length; i++)
                {
                    gesArrayDown.push(rowsRechnung2[i]['prov'])
                    gesArrayDown.push(rowsRechnung2[i]['abr'])
                    if (rowsRechnung2[i]['wartung'].length != 0)
                    {
                        for (let o = 0; o < rowsRechnung2[i]['wartung'].length; o++)
                            gesArrayDown.push(rowsRechnung2[i]['wartung'][o])
                    }
                }

                if (downloadSelect.value.length === 0)
                    downloadSelect.value = gesArrayDown
                else
                    downloadSelect.value = []


            },
            openKalenderRechVonBis()
            {
                $('.rechVomBis i').click()
            },
            openKalenderRechBis()
            {
                $('.rechBis i').click()
            },
            openKalenderRechDatum()
            {
                $('.rechDatum i').click()
            },
            openKalenderVorgAnreise()
            {
                $('.datumAn i').click()
            },
            openKalenderVorgAbreise()
            {
                $('.datumAb i').click()
            },
            openKalenderVorgDatum()
            {
                $('.datumI i').click()
            },
            openKalenderVorgVonBis()
            {
                $('.datumAnAb i').click()
            },openKalenderVorgDatum()
            {
                $('.datumI i').click()
            },
            VonBisABR(range)
            {
                datumVonBis.value = range['from']['day'] + '.' + range['from']['month'] + '.' + range['from']['year'] + '  -  ' + range['to']['day'] + '.' + range['to']['month'] + '.' + range['to']['year']
            },
            VonBisVorg(range)
            {
                datumVonBisVorg.value = range['from']['day'] + '.' + range['from']['month'] + '.' + range['from']['year'] + '  -  ' + range['to']['day'] + '.' + range['to']['month'] + '.' + range['to']['year']
            },
            openMobilWindow()
            {
                let splitter = $('.q-table__top.relative-position.row.items-center')[0]['classList']['value'].split(" ");
                let check = true;

                for (let i = 0; i < splitter.length; i++)
                {
                    if (splitter[i] === 'mobilLeftFly' && check !== false)
                        check = false
                    else
                        check = true
                }

                if (check === true)
                {
                    $('.q-table__top.relative-position.row.items-center').addClass('mobilLeftFly')
                    setTimeout(function() {
                        $('#q-app .q-table__top.relative-position.row.items-center .icon-head-mobil').addClass('rotIcon')
                    }, 1000);
                }
                else
                {
                    $('.q-table__top.relative-position.row.items-center').removeClass('mobilLeftFly')
                    setTimeout(function() {
                        $('#q-app .q-table__top.relative-position.row.items-center .icon-head-mobil').removeClass('rotIcon')
                    }, 1000);
                }
            },

            filterFn (val, update)
            {
                if (val === '')
                {
                    update(() => {
                        options.value = stringOptions
                    })
                    return
                }

                update(() => {
                    const needle = val.toLowerCase()
                    options.value = stringOptions.filter(v => v.toLowerCase().indexOf(needle) > -1)
                })
            },

            filterFn (val, update)
            {
                if (val === '')
                {
                    update(() => {
                        options.value = stringOptions
                    })
                    return
                }

                update(() => {
                    const needle = val.toLowerCase()
                    options.value = objekte3.filter(v => v.toLowerCase().indexOf(needle) > -1)
                })
            },

            downloadeRech()
            {
                if (downloadSelect['_rawValue'][0] != null) {
                    $.request('onMultiDownload', {
                        data: {
                            mail: '2',
                            file: this.RechSelect
                        },
                        download: true,
                        flash: true,
                    })

                    /*$.oc.flashMsg({
                        'text': 'Record saved.',
                        'class': 'success',
                        'interval': 3
                    })*/
                }
                else
                {
                    $q.notify({
                        type: 'negative',
                        message: errorMessage
                    })
                }
            },

            closeMobileMenu()
            {
                $('.icon-head-mobil').click()
            },

            isButtonDisabeld()
            {
                const mailSlitt = mailSendInput.value.split(";");
                const emailPattern = /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/;

                for (let i = 0; i < mailSlitt.length; i++)
                {
                    if (!emailPattern.test(mailSlitt[i]))
                    {
                        $('#selectDivMultiMail').html(keineMailGefunden)
                        return false
                    }
                }

                var returnString = ''
                for (let i = 0; i < mailSlitt.length; i++)
                    returnString = returnString + '<div style="width: max-content; float: left; margin-right: 8px; margin-bottom: 8px;"> <div style="width: max-content; padding: 0px 5px; border-radius: 5px; background-color: #e6e6e6; box-shadow: 0 1px 5px #0003, 0 2px 2px #00000024, 0 3px 1px -2px #0000001f; margin-bottom: 8px;">' + mailSlitt[i] + '</div></div>'

                $('#selectDivMultiMail').html(returnString)

                if (mailSendInputCC.value === '' || emailPattern.test(mailSendInputCC.value))
                    return true
                else
                    return false
            },

            sendAbrMailJs()
            {
                var valSelect = ''
                for (let i = 0; i < downloadSelect.value.length; i++)
                {
                    if (valSelect === '')
                        valSelect = downloadSelect.value[i]
                    else
                        valSelect = valSelect + ',' + downloadSelect.value[i]
                }

                $().request('onSendAbrMail', {data: {file: valSelect, betreff: mailSendInputBesch.value, cc: mailSendInputCC.value, mail: mailSendInput.value, value: messageValue.value}, flash: true})
            },

            changeValueSelect(value, event)
            {
                if (value == '')
                    progess.value = false
                else
                    progess.value = true

                var valSelect = ''
                for (let i = 0; i < value.length; i++)
                {
                    if (valSelect === '')
                    {
                        valSelect = value[i]
                        selectCheckboxDownload.push(value[i])
                    }
                    else
                    {
                        valSelect = valSelect + ',' + value[i]
                        selectCheckboxDownload.push(value[i])
                    }
                }
                this.RechSelect = valSelect

                let setArray;
                selected.value = []
                for (let i = 0; i < event['view']['abrechnungen'].length; i++)
                {
                    if ((jQuery.inArray(event['view']['abrechnungen'][i]['prov'], value) !== -1) && (jQuery.inArray(event['view']['abrechnungen'][i]['abr'], value) !== -1))
                    {
                        if (event['view']['abrechnungen'][i]['wartung'].length === 0 && event['view']['abrechnungen'][i]['belege'].length === 0)
                        {
                            setArray = {
                                'V2WartungName': event['view']['abrechnungen'][i]['V2WartungName'],
                                'abr': event['view']['abrechnungen'][i]['abr'],
                                'art': event['view']['abrechnungen'][i]['art'],
                                'betrag': event['view']['abrechnungen'][i]['betrag'],
                                'datum': event['view']['abrechnungen'][i]['datum'],
                                'jahr': event['view']['abrechnungen'][i]['jahr'],
                                'monat': event['view']['abrechnungen'][i]['monat'],
                                'prov': event['view']['abrechnungen'][i]['prov'],
                                'provbetrag': event['view']['abrechnungen'][i]['provbetrag'],
                                'rechnr': event['view']['abrechnungen'][i]['rechnr'],
                                'to': event['view']['abrechnungen'][i]['to'],
                                'von': event['view']['abrechnungen'][i]['von'],
                                'wartung': event['view']['abrechnungen'][i]['wartung'],
                                'xx': event['view']['abrechnungen'][i]['xx']
                            }
                            selected.value.push(setArray)
                        }
                        else
                        {
                            let wartungCheckMark = true;
                            for (let b = 0; b < event['view']['abrechnungen'][i]['wartung'].length; b++)
                            {
                                if (jQuery.inArray(event['view']['abrechnungen'][i]['wartung'][b], value) !== -1)
                                    continue
                                else
                                    wartungCheckMark = false
                            }

                            for (let b = 0; b < event['view']['abrechnungen'][i]['belege'].length; b++)
                            {
                                if (jQuery.inArray(event['view']['abrechnungen'][i]['belege'][b], value) !== -1)
                                    continue
                                else
                                    wartungCheckMark = false
                            }

                            if (wartungCheckMark === true)
                            {
                                setArray = {
                                    'V2WartungName': event['view']['abrechnungen'][i]['V2WartungName'],
                                    'abr': event['view']['abrechnungen'][i]['abr'],
                                    'art': event['view']['abrechnungen'][i]['art'],
                                    'betrag': event['view']['abrechnungen'][i]['betrag'],
                                    'datum': event['view']['abrechnungen'][i]['datum'],
                                    'jahr': event['view']['abrechnungen'][i]['jahr'],
                                    'monat': event['view']['abrechnungen'][i]['monat'],
                                    'prov': event['view']['abrechnungen'][i]['prov'],
                                    'provbetrag': event['view']['abrechnungen'][i]['provbetrag'],
                                    'rechnr': event['view']['abrechnungen'][i]['rechnr'],
                                    'to': event['view']['abrechnungen'][i]['to'],
                                    'von': event['view']['abrechnungen'][i]['von'],
                                    'wartung': event['view']['abrechnungen'][i]['wartung'],
                                    'xx': event['view']['abrechnungen'][i]['xx']
                                }
                                selected.value.push(setArray)
                            }
                        }
                    }
                }
            },

            setSelectValue(details)
            {
                var value = downloadSelect.value
                selectCheckboxDownload = downloadSelect.value

                if (details.added === true) {
                    for (let i = 0; i < details.rows.length; i++)
                    {
                        if (!value.includes(details.rows[i]['abr']))
                            selectCheckboxDownload.push(details.rows[i]['abr'])

                        if (!value.includes(details.rows[i]['prov']))
                            selectCheckboxDownload.push(details.rows[i]['prov'])

                        for (let o = 0; o < details.rows[i]['wartung'].length; o++)
                        {
                            if (!value.includes(details.rows[i]['wartung'][o]))
                                selectCheckboxDownload.push(details.rows[i]['wartung'][o])
                        }

                        for (let o = 0; o < details.rows[i]['belege'].length; o++)
                        {
                            if (!value.includes(details.rows[i]['belege'][o]))
                                selectCheckboxDownload.push(details.rows[i]['belege'][o])
                        }
                    }
                }
                else
                {
                    for (let i = 0; i < details.rows.length; i++)
                    {
                        if (value.includes(details.rows[i]['abr']))
                            selectCheckboxDownload.splice(selectCheckboxDownload.indexOf(details.rows[i]['abr']), 1)

                        if (value.includes(details.rows[i]['prov']))
                            selectCheckboxDownload.splice(selectCheckboxDownload.indexOf(details.rows[i]['prov']), 1)

                        for (let o = 0; o < details.rows[i]['wartung'].length; o++) {
                            if (value.includes(details.rows[i]['wartung'][o]))
                                selectCheckboxDownload.splice(selectCheckboxDownload.indexOf(details.rows[i]['wartung'][o]), 1)
                        }

                        for (let o = 0; o < details.rows[i]['belege'].length; o++) {
                            if (value.includes(details.rows[i]['belege'][o]))
                                selectCheckboxDownload.splice(selectCheckboxDownload.indexOf(details.rows[i]['belege'][o]), 1)
                        }
                    }
                }

                downloadSelect.value = selectCheckboxDownload

                if (downloadSelect.value.length == 0)
                    progess.value = false
                else
                    progess.value = true

                let gewaelt = ''
                for (let i = 0; i < downloadSelect.value.length; i++)
                {
                    if (gewaelt === '')
                        gewaelt = downloadSelect.value[i]
                    else
                        gewaelt = gewaelt + ',' + downloadSelect.value[i]
                }

                this.RechSelect = gewaelt
                //setDownloadButton(downloadSelect.value)
            },

            belegen(value)
            {
                if (value != null)
                {
                    if (typeof value === 'string' || value instanceof String)
                    {
                        $("#obInput").val(objekte[objekte3.indexOf(value)]['id']);
                        setTimeout(function()
                        {
                            $('#a123e9').text(objekte[objekte3.indexOf(value)]['titel']);
                        }, 400);
                    }
                    else
                    {
                        $("#obInput").val(value['value']);
                        setTimeout(function()
                        {
                            $('#a123e9').text(value['label']);
                        }, 400);
                    }
                    setTimeout(function()
                    {
                        $('#senderBTN').click();
                    }, 1);
                }
            },

            addDefaultRows2()
            {
                rows.value = rows2
            },
            addDefaultRows3()
            {
                rowsObjekte.value = rowsObjekte2
            },
            addDefaultRows4()
            {
                rowsRechnung.value = rowsRechnung2
            },

            removeRow (index)
            {
                if (objid.value == null || obj.value == null)
                {
                    obj.value = ''
                    objid.value = ''
                }

                if ((objid.value.length >= 1 && obj.value.length === 0) || (objid.value.length === 0 && obj.value.length >= 1))
                {
                    if (objid.value.length >= 1 && obj.value.length === 0)
                    {
                        for (let i = 0; i < rows2.length; i++)
                        {
                            if (rows2[i]['objid'] == objid.value)
                                obj.value = rows2[i]['objekt']
                        }
                    }
                    else
                    {
                        for (let i = 0; i < rows2.length; i++)
                        {
                            if (rows2[i]['objekt'] == obj.value)
                                objid.value = rows2[i]['objid']
                        }
                    }
                }
                else
                {
                    for (let i = 0; i < rows2.length; i++)
                    {
                        if (rows2[i]['objekt'] == index)
                        {
                            objid.value = rows2[i]['objid']
                            obj.value = rows2[i]['objekt']
                        }
                        else if (rows2[i]['objid'] == index)
                        {
                            objid.value = rows2[i]['objid']
                            obj.value = rows2[i]['objekt']
                        }
                    }
                }

                loading.value = true

                if (index !== '')
                {
                    setTimeout(() =>
                    {
                        rows.value = rows2

                        let id = $('.id input').val()
                        let objekt = $('.objekt input').val()
                        let objid = $('.objid input').val()
                        let art = $('.art input').val()

                        let vonBis = datumVonBisVorg.value
                        let datum = vorgDatum.value
                        vonBis = vonBis.split("  -  ");

                        if (filterArtAbrModel.value == '')
                        {
                            back = []
                            for (let i = 0; i < rows.value.length; i++)
                            {
                                if ((rows.value[i]['id'] === id || id === '') && (rows.value[i]['objekt'] === objekt || objekt === '') && (rows.value[i]['objid'] === objid || objid === '') && (rows.value[i]['art'] === art || art === ''))
                                    back.push(rows.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === anreise)
                        {
                            if (vonBis != '')
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                {
                                    if ((new Date(rows.value[i]['anreise'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis == '') && (new Date(rows.value[i]['anreise'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis == '') && (rows.value[i]['id'] === id || id === '') && (rows.value[i]['objekt'] === objekt || objekt === '') && (rows.value[i]['objid'] === objid || objid === '') && (rows.value[i]['art'] === art || art === ''))
                                        back.push(rows.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                    back.push(rows.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === abreise)
                        {
                            if (vonBis != '')
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                {
                                    if ((new Date(rows.value[i]['abreise'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis == '') && (new Date(rows.value[i]['abreise'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis == '') && (rows.value[i]['id'] === id || id === '') && (rows.value[i]['objekt'] === objekt || objekt === '') && (rows.value[i]['objid'] === objid || objid === '') && (rows.value[i]['art'] === art || art === ''))
                                        back.push(rows.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                    back.push(rows.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === abUndAbreise)
                        {
                            if (vonBis != '')
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                {
                                    if ((new Date(rows.value[i]['anreise'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis == '') && (new Date(rows.value[i]['abreise'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis == '') && (rows.value[i]['id'] === id || id === '') && (rows.value[i]['objekt'] === objekt || objekt === '') && (rows.value[i]['objid'] === objid || objid === '') && (rows.value[i]['art'] === art || art === ''))
                                        back.push(rows.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                    back.push(rows.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === buchungsdatum)
                        {
                            if (vonBis != '')
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                {
                                    if ((new Date(rows.value[i]['datum'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis == '') && (new Date(rows.value[i]['datum'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis == '') && (rows.value[i]['id'] === id || id === '') && (rows.value[i]['objekt'] === objekt || objekt === '') && (rows.value[i]['objid'] === objid || objid === '') && (rows.value[i]['art'] === art || art === ''))
                                        back.push(rows.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rows.value.length; i++)
                                    back.push(rows.value[i])
                            }
                        }

                        rows.value = back
                        loading.value = false
                    }, 100)
                }
                else
                {
                    rows.value = rows2
                    loading.value = false
                }
            },

            removeRowObjekte (index)
            {
                if (objektNr.value == null || objektName.value == null)
                {
                    objektName.value = ''
                    objektNr.value = ''
                }

                if ((objektNr.value.length >= 1 && objektName.value.length === 0) || (objektNr.value.length === 0 && objektName.value.length >= 1))
                {
                    if (objektNr.value.length >= 1 && objektName.value.length === 0)
                    {
                        for (let i = 0; i < rowsObjekte2.length; i++)
                        {
                            if (rowsObjekte2[i]['id'] == objektNr.value)
                                objektName.value = rowsObjekte2[i]['titel']
                        }
                    }
                    else
                    {
                        for (let i = 0; i < rowsObjekte2.length; i++)
                        {
                            if (rowsObjekte2[i]['titel'] == objektName.value)
                                objektNr.value = rowsObjekte2[i]['id']
                        }
                    }
                }
                else
                {
                    for (let i = 0; i < rowsObjekte2.length; i++)
                    {
                        if (rowsObjekte2[i]['titel'] == index)
                        {
                            objektNr.value = rowsObjekte2[i]['id']
                            objektName.value = rowsObjekte2[i]['titel']
                        }
                        else if (rowsObjekte2[i]['id'] == index)
                        {
                            objektNr.value = rowsObjekte2[i]['id']
                            objektName.value = rowsObjekte2[i]['titel']
                        }
                    }
                }

                loadingObjekte.value = true
                if (index !== '')
                {
                    setTimeout(() => {
                        rowsObjekte.value = rowsObjekte2

                        var nr = $('.objNr input').val()
                        var titel = $('.objName input').val()
                        var intern = $('.objIntern input').val()
                        var personen = $('.objPersonen input').val()
                        var groesse = $('.objGroesse input').val()

                        back = []
                        for (let i = 0; i < rowsObjekte.value.length; i++)
                        {
                            if ((rowsObjekte.value[i]['id'] === nr || nr === '') && (rowsObjekte.value[i]['titel'] === titel || titel === '') && (rowsObjekte.value[i]['intern'] === intern || intern === '') && (rowsObjekte.value[i]['qm'] === groesse || groesse === '') && (rowsObjekte.value[i]['pers'].toString() === personen || personen === ''))
                                back.push(rowsObjekte.value[i])
                        }

                        rowsObjekte.value = back
                        loadingObjekte.value = false
                    }, 100)
                }
                else
                {
                    rowsObjekte.value = rowsObjekte2
                    loadingObjekte.value = false
                }
            },

            removeRowRech (index)
            {
                if (index !== '')
                {
                    loadingRech.value = true

                    setTimeout(() => {
                        rowsRechnung.value = rowsRechnung2

                        let id = $('.rechId input').val()
                        let vonBis = datumVonBis.value

                        if (filterArtAbrModel.value == '')
                        {
                            back = []
                            for (let i = 0; i < rowsRechnung.value.length; i++)
                            {
                                if ((rowsRechnung.value[i]['rechnr'] === id || id === ''))
                                    back.push(rowsRechnung.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === anreise)
                        {
                            if (vonBis !== '')
                            {
                                vonBis = vonBis.split("  -  ");
                                console.log(vonBis)

                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                {
                                    if ((rowsRechnung.value[i]['rechnr'] === id || id === '') &&  (new Date(rowsRechnung.value[i]['von'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis === '') && (new Date(rowsRechnung.value[i]['von'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis === '') )
                                        back.push(rowsRechnung.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                    back.push(rowsRechnung.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === abreise)
                        {
                            if (vonBis !== '')
                            {
                                vonBis = vonBis.split("  -  ");

                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                {
                                    if ((rowsRechnung.value[i]['rechnr'] === id || id === '') && (new Date(rowsRechnung.value[i]['to'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis === '') && (new Date(rowsRechnung.value[i]['to'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis === '') )
                                        back.push(rowsRechnung.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                    back.push(rowsRechnung.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === abUndAbreise)
                        {
                            if (vonBis !== '')
                            {
                                vonBis = vonBis.split("  -  ");

                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                {
                                    if ((rowsRechnung.value[i]['rechnr'] === id || id === '') && (new Date(rowsRechnung.value[i]['von'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis === '') && (new Date(rowsRechnung.value[i]['to'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis === '') )
                                        back.push(rowsRechnung.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                    back.push(rowsRechnung.value[i])
                            }
                        }
                        else if (filterArtAbrModel.value === abrZeitraum)
                        {
                            if (vonBis !== '')
                            {
                                vonBis = vonBis.split("  -  ");

                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                {
                                    if ((rowsRechnung.value[i]['rechnr'] === id || id === '') && (new Date(rowsRechnung.value[i]['datum'].split('.').reverse().join('/')) >= new Date(vonBis[0].split('.').reverse().join('/')) || vonBis === '') && (new Date(rowsRechnung.value[i]['datum'].split('.').reverse().join('/')) <= new Date(vonBis[1].split('.').reverse().join('/')) || vonBis === '') )
                                        back.push(rowsRechnung.value[i])
                                }
                            }
                            else
                            {
                                back = []
                                for (let i = 0; i < rowsRechnung.value.length; i++)
                                    back.push(rowsRechnung.value[i])
                            }
                        }

                        rowsRechnung.value = back
                        loadingRech.value = false
                    }, 100)
                }
                else
                {
                    rowsRechnung.value = rowsRechnung2
                    loadingRech.value = false
                }
            },

            removeRowRechDatum(value)
            {
                if (value != null)
                {
                    rowsRechnung.value = rowsRechnung2
                    if (value['from'] !== undefined && value['to'] !== undefined)
                    {
                        back = []
                        $('#datumRechInput').val(value['from'] + ' - ' + value['to'])

                        for (let i = 0; i < rowsRechnung.value.length; i++)
                        {
                            if (new Date(rowsRechnung.value[i]['datum'].split('.').reverse().join('/')) >= new Date(value['from'].split('.').reverse().join('/')) && new Date(rowsRechnung.value[i]['datum'].split('.').reverse().join('/')) <= new Date(value['to'].split('.').reverse().join('/')))
                                back.push(rowsRechnung.value[i])
                        }

                        rowsRechnung.value = back
                        loadingRech.value = false

                    }
                    else
                    {
                        $('#datumRechInput').val(value)
                        back = []

                        for (let i = 0; i < rowsRechnung.value.length; i++)
                        {
                            if (rowsRechnung.value[i]['datum'] == value)
                                back.push(rowsRechnung.value[i])
                        }

                        rowsRechnung.value = back
                        loadingRech.value = false
                    }
                }
            },

            removeRowVorgDatum(value)
            {
                if (value != null)
                {
                    rows.value = rows2
                    loading.value = true

                    if (value['from'] !== undefined && value['to'] !== undefined)
                    {
                        back = []
                        $('#datumRechInput').val(value['from'] + ' - ' + value['to'])

                        for (let i = 0; i < rows.value.length; i++)
                        {
                            if (new Date(rows.value[i]['datum'].split('.').reverse().join('/')) >= new Date(value['from'].split('.').reverse().join('/')) && new Date(rows.value[i]['datum'].split('.').reverse().join('/')) <= new Date(value['to'].split('.').reverse().join('/')))
                                back.push(rows.value[i])
                        }

                        rows.value = back
                        loading.value = false
                    }
                    else
                    {
                        $('#datumRechInput').val(value)
                        back = []

                        for (let i = 0; i < rows.value.length; i++)
                        {
                            if (rows.value[i]['datum'] == value)
                                back.push(rows.value[i])
                        }

                        loading.value = false
                        rows.value = back
                    }
                }
            },

            getRequestData(data, eId)
            {
                return 'file: \'' + data + '\', fileid: ' + eId
            },

            exportTable (rows, colums, name)
            {
                const content = [colums.map(col => wrapCsvValue(col.label))].concat(
                    rows.map(row => colums.map(col => wrapCsvValue(
                        typeof col.field === 'function'
                            ? col.field(row)
                            : row[ col.field === void 0 ? col.name : col.field ],
                        col.format,
                        row
                    )).join(';'))
                ).join('\r\n')

                let v2 = content

                for (let i = 0; i < colums.map(col => wrapCsvValue(col.label)).length; i++)
                    v2 = v2.replace(",", ";")

                const status = exportFile(
                    name + '.csv',
                    v2,
                    'text/csv'
                )

                if (status !== true)
                {
                    $q.notify({
                        message: 'Browser denied file download...',
                        color: 'negative',
                        icon: 'warning'
                    })
                }
            }
        }
    }
})

app.use(Quasar, { config: {} })
app.mount('#q-app')
