# Updatehinweise / Upgrade Guide
> **HINWEIS!**  
> Die Bearbeitung eines Partials ist nur dann notwendig, wenn das entsprechende Partial einer Komponente im Backend angepasst wurde.  
> Die angepassten Partials finden Sie im Backend unter _CMS > Partials_. Schauen Sie hier, ob das entsprechende Partial zu finden ist.
- - -

## Upgrade 3.10.6
In der Buchungsmaske kann der Gast jetzt angeben, ob es sich bei der Buchung um eine Geschäftsreise handelt. Wird diese Option ausgewählt, entfallen die Anzeige und Berechnung der Kurtaxe im Buchungs- und Zahlungsprozess.  
Die Option kann in der Buchungsmaske-Komponente über das Feld _Buchungsdaten > Auswahl für Geschäftsreise anzeigen_ aktiviert oder deaktiviert werden.

### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente **_Buchungsmaske_** _default.htm_ und _variant2.htm_:  
Unterhalb des Div-Containers ``<div class="fewo_buchung_personen"> ... </div>`` muss folgender Code eingefügt werden.
````
{% if useIsBusinessTrip %}
    <div class="businessTrip">
        <div class="label">{{ labels.geschaeftsreise }}</div>
        <input type="checkbox" id="ctrl_isBusinessTrip" name="isBusinessTrip" data-request="{{ __SELF__ }}::onChangeBusinessTrip" />
    </div>
{% endif %}
````
- - -

## Upgrade 3.9.46
Die Ausgabe der regionalen Registrierungsnummer und der nationalen Registrierungsnummer auf der Objektdetailseite ist nun möglich. Dazu einfach folgende Code-Snippets an der gewünschten Stelle im Code der Objektdetailseite einfügen:

Regionale Registrierungsnummer
````
{{ Objektdetail.RegionaleRegistrierungsnr|raw }}
````
Nationale Registrierungsnummer
````
{{ Objektdetail.NationaleRegistrierungsnr|raw }}
````

Die dazugehörigen Labels können in der Komponente **_Obj-Details_** unter _Detail-Labels_ angepasst werden.
- - -

## Upgrade 3.8.19
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente **_Eigentümerdaten_** _default.htm_:  
Innerhalb des Code-Blocks ``var abrTable = $('#abrechnungen').DataTable({...})`` muss folgender Code für das ``columnDefs``-Objekt hinzugefügt werden:
````
{
    targets: 4,
    sortable: true,
    type: 'de_date',
},
````
Innerhalb des Code-Blocks ``var table = $('#vorgaenge').DataTable({...})`` muss folgender Code für das ``columnDefs``-Objekt hinzugefügt werden:
````
{
    targets: 2,
    visible: true,
    searchable: true,
    sortable: true,
    type: 'de_date',
},
````
- - -

## Upgrade 3.8.11
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente **_Objektliste_** _default.htm_:  
Der Folgende Code-Block muss **UNTER** den Code-Block ``{% if objekt.Adresse %} . . . {% endif %}`` eingefügt werden:
````
{% if objekt.alternativeZeitraeume %}
    <div class="fewo-alternative d-inline-block">
        {{ alternativeLabel|raw }}
        {% for alternative in objekt.alternativeZeitraeume %}
            <div class="fewo-alternative-item"><a href="{{ alternative.href }}">{{ alternative.label|raw }}</a></div>
        {% endfor %}
    </div>
{% endif %}
{% if objekt.buchungsluecken %}
    <div class="fewo-buchungsluecken d-inline-block">
        {{ buchungslueckenLabel|raw }}
        {% for luecke in objekt.buchungsluecken %}
            <div class="fewo-buchungsluecken-item"><a href="{{ luecke.href }}">{{ luecke.label|raw }}</a></div>
        {% endfor %}
    </div>
{% endif %}
````
- - -

## Upgrade 3.7.6
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente **_Belegungsplan_** _default.htm_:  
Folgende Code-Zeile muss unter der Zeile ``var caloffset = '{{ caloffset }}';`` eingefügt werden:
````
var mindaysText = '{{ minnaechte }}';
````
- - -

## Upgrade 3.7.3
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente **_Eigentümerdaten_** _default.htm_:  
Folgende Code-Zeile **über** der Zeile ``<table id="abrechnungen" class="display" style="width:100%">`` einfügen:
````
<div id="abr-error"></div>
````

&nbsp;

**Optionale Anpassung** (wenn Ausgabe nicht erwünscht, ist diese Anpassung nicht notwendig)  
Komponente **_Buchungsmaske_** _zusammen.htm_:  
Folgender Code-Block muss unter den Code-Block ``{% if data.zahlung2 > 0 %} ... {% endif %}`` eingefügt werden:
````
{% if istZahlung and data.kurtaxePreis > 0 %}
    <div class="kurtaxe_hinweis">{{ zahlungKurtaxeHinweis|raw }}</div>
{% endif %}
````
- - -

## Upgrade 3.7.0
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente **_Eigentümerdaten_** _default.htm_:  
Der Code-Block für die Eigenbelegungen... 
````
{% if showbelegen %}
    ...
    ### Hier steht der restliche Code ###
    ...
{% endif %}
````
... muss durch folgenden Code ersetzt werden:
````
{% if showbelegen %}
    <div role="tabpanel" class="tab-pane" id="4">
        <div id="bookingMask">
            <form class="eigenbelegung_form" method="post" data-request="{{ __SELF__ }}::onBelegung">
                <div class="bel_objekt">
                    <div class="label label_objektauswahl">{{ labels.belobjekt }}</div>
                    <select id="ctrl_objekt" class="select frm_objekt" name="objekt" data-request="{{ __SELF__ }}::onObjektChange" style="width:300px;">
                        {% for key, obj in belobjekte %}
                            <option value="{{ key }}">{{ obj|raw }}</option>
                        {% endfor %}
                    </select>
                </div>
                <div id="belegung"></div>
            </form>
        </div>
    </div>
{% endif %}
````
Folgende Code-Zeile muss gelöscht werden:
````
$('#ctrl_objekt').select2({});
````
Die Code-Zeile ``{"data": "titel"},`` muss durch folgenden Code ersetzt werden:
````
{"data": "titel",
    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
        $(nTd).html("<a target='_blank' href='" + oData.href + "'>" + oData.titel + "</a>");
    }
},
````
- - -

## Upgrade 3.6.3
### Umstellung der PHP-Version für October 1 (PHP 7.4) und October 3 (PHP 8.1)
> **WICHTIG! Bitte lesen**  
>  
> Informationen zu October 1:  
> Bitte stellen Sie Ihre PHP-Version auf **PHP 7.4** um, sollten Sie weiterhin **October 1** benutzen.
> 
> Informationen zu October 3:  
> Ab sofort ist die Verwendung des neuen October 3 möglich. Bitte stellen Sie Ihre Version auf **PHP 8.1** um, sollten Sie die neue **October 3** Version benutzen.
- - -

## Upgrade 3.6.0
### Folgende Partialanpassungen sind für dieses Update notwendig

Komponente **_Objektliste_** _default.htm_:  
Bild und Bild-Slider  
Das alt-Attribut und das title-Attribut beider img-Tags (einfaches Bild und Slider) müssen durch folgenden Code ersetzt werden:

````
alt="{% if objekt.image_title %}{{ objekt.image_title }}{% else %}{{ objekt.TitelFuerTags|raw }}{% endif %}"{% if objekt.image_title %} title="{{ objekt.image_title }}"{% endif %}
````

&nbsp;

Komponente **_Buchungsmaske_** _btnend.htm_ und _btnend-variant2.htm_:  
Die Code-Zeile für den Button mit der class ``fewo-btnweiter`` muss durch folgende Code-Zeilen ersetzt werden.
````
{% if btnbuchen != '' %}
    <button id="btnweiter6" class="fewo-btnweiter fewo-btnend" onclick="$('.fewo-btnend').hide();" data-request="{{ __SELF__ }}::onBtnBuchen" data-request-data="btype: 'B'">{{ btnbuchen }}</button>
{% endif %}

{% if btnanfragen != '' %}
    <button id="btnweiter6" class="fewo-btnweiter fewo-btnend" onclick="$('.fewo-btnend').hide();" data-request="{{ __SELF__ }}::onBtnBuchen" data-request-data="btype: 'A'">{{ btnanfragen }}</button>
{% endif %}
````
- - -

## Upgrade 3.5.35
### Folgende Partialanpassungen sind für dieses Update notwendig

Komponente **_Hausliste_** _default.htm_:  
Der JavaScript-Codeblock für das Laden der Hauskarte muss entfernt und durch ``<div id="hausmap-{{ haus.id }}">{{ haus.hausmap|raw }}</div>`` ersetzt werden. Der Code befindet sich nun in dem Partial _hausmap.htm_.

Dieser Code...
````
{% if haus.map %}
    <div class="fewo-map">
    <div id="mapid{{ haus.id }}" class="fewo-hausmap" style="height:{{ mapheight }}px;"></div>
        <script>
            jQuery(document).ready(function() {
                ...
                ### Hier steht der restliche Code ###
                ...
            });
        </script>
    </div>
{% endif %}
````
...muss gelöscht und durch...
````
<div id="hausmap-{{ haus.id }}">{{ haus.hausmap|raw }}</div>
````
...ersetzt werden.

&nbsp;

Komponente **_Objektmap_** _default.htm_:  
Der Div-Container mit der ID _map_ und der JavaScript-Codeblock für das Laden der Karte muss entfernt und durch ``<div id="objmap">{{ objmap|raw }}</div>`` ersetzt werden. Der Code befindet sich nun in dem Partial _map.htm_.

Dieser Code...
````
<div id="map" class="fewo-listmap" style="height:600px;"></div>
<script>
    jQuery(document).ready(function() {
        ...
        ### Hier steht der restliche Code ###
        ...
    });
</script>
````
...muss entfernt und durch...
````
<div id="objmap">{{ objmap|raw }}</div>
````
...ersetzt werden.
- - -

## Upgrade 3.5.34
### Folgende Partialanpassungen sind für dieses Update notwendig

Komponente **_Buchungsmaske_** _preise.htm_:  
Der folgende Code ist für die Ausgabe der Kurtaxe in der Buchungsmaske zuständig und muss oberhalb von ``<!-- Gesamtsumme -->`` oder an anderer beliebiger Stelle in diesem Partial eingefügt werden:
````
{% if kurtaxe > 0 %}
    <div class="zeile zeile_preise kurtaxe">
        <div class="zeilensummentitel sum_titel">{{ summen.kurtaxe }}</div>
        <div class="zeilesumme kurtaxe">{{ kurtaxe }}</div>
    </div>
{% endif %}
````

Komponente **_Preisrechner_** _default.htm_:
Der folgende für die Ausgabe der Kurtaxe im Preisrechner zuständig und muss unterhalb von ``<div id="kaution">{{ kaution }}</div>`` oder an anderer beliebiger Stelle in diesem Partial eingefügt werden:
````
<div class="label">{{ pkurtaxelabel }}</div>
<div id="kurtaxe">{{ kurtaxe }}</div>
````

Komponente **_Bewertungen_** _default.htm_:  
Die Code-Zeile ``src="{{ bewertung.image|raw }}"`` für das img-Tag muss durch folgenden Code ersetzt werden:
````
src="{{ bewertung.image.path }}"
````
- - -

## Upgrade 3.5.33
### Folgende Partialanpassungen sind für dieses Update notwendig

Komponente **_Objektliste_** _default.htm_:  

**Schritt 1 (Gesamt Map):**  
Der JavaScript-Codeblock für das Laden der Gesamtkarte muss entfernt und durch ``<div id="objGesMapContainer">{{ objgesmap|raw }}</div>`` ersetzt werden. Der Code befindet sich nun in dem Partial _objgesmap.htm_.

Dieser Code...
````
{% if showmap == true %}
    {% if mapOption == true %}
        <div id="fewo-listmap">
            <div id="map" class="fewo-listmap" style="height:{{gesmapheight}}px;"></div>
            <script>
            ...
            ### Hier steht der restliche Code ###
            ...
        </script>
    {% endif %}
{% endif %}
````
...muss gelöscht und durch...
````
<div id="objGesMapContainer">{{ objgesmap|raw }}</div>
````
...ersetzt werden.

**Schritt 2 (Map pro Objekt):**  
Der JavaScript-Codeblock für das Laden der einzelnen Objektkarten muss entfernt und durch ``<div id="objMapContainer-{{ objekt.id }}">{{ objekt.objmap|raw }}</div>`` ersetzt werden. Der Code befindet sich nun in dem Partial _objmap.htm_.

Dieser Code...
````
{% if objekt.map == true %}
    {% if mapOption == true %}
        <div class="fewo-map">
            <div id="mapid{{ objekt.id }}" class="fewo-objektmap" style="height:{{ mapheight }}px;"></div>
            <script>
            ...
            ### Hier steht der restliche Code ###
            ...
        </script>
    {% endif %}
{% endif %}
````
...muss gelöscht und durch...
````
<div id="objMapContainer-{{ objekt.id }}">{{ objekt.objmap|raw }}</div>
````
...ersetzt werden.


Komponente **_ObjektBewertungen_** _item.htm_:

Der Bewertungstitel wird nun in einem ``<p>``-Tag geladen. Dafür einfach folgende Zeile in diesem Partial wie folgt anpassen:
````
<div class="bew_titel"><p>{{ bewertung.titel|raw }}</p></div>
````
- - -

## Upgrade 3.5.23
### Folgende Partialanpassungen sind für dieses Update notwendig

Komponente **_Buchungsmaske_** _variant2.htm_ und _leistungen.htm_: Der folgende Code muss oberhalb der Zeile ``{% for leist in optleistungen %}`` eingefügt werden:
````
{% if showTooltip %}
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
{% endif %}
````

Komponente **_Buchungsmaske_** _variant2.htm_ und _leistungen.htm_: Der folgende Code muss hinter ``{{ leist.titel }}`` eingefügt werden:
````
{% if showTooltip %}<span class="fewo-tooltip" data-toggle="tooltip" data-placement="right" title="{{ leist.tooltip|raw }}"></span>{% endif %}
````

## Upgrade 3.5.19
### Folgende Partialanpassungen sind für dieses Update notwendig

Komponente **_Angebot-Detail_** _default.htm_: Die Code-Zeile ``src="{{ image.thumb(image_width,image_height) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ image|raw }}"
````

Komponente **_Angebot-Detail_** _objlist.htm_: Die Code-Zeile ``src="{{ objekt.image.thumb(objekt.image_width,objekt.image_height) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ objekt.image|raw }}"
````

Komponente **_Angebote_** _default.htm_: Die Code-Zeile ``src="{{ angebot.image.thumb(image_width,image_height) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ angebot.image|raw }}"
````

Komponente **_Buchungsmaske_** _default.htm_ und _variant2.htm_: Die Code-Zeile ``src="{{ ang_image.thumb(200,200) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ ang_image|raw }}"
````

Komponente **_Galerie_** _default.htm_: Die Code-Zeile ``src="{{ image.thumb( gal_width , gal_height ) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ image.thumb|raw }}"
````

Komponente **_Bewertungen_** _default.htm_: Die Code-Zeile ``src="{{ bewertung.image.thumb( img_width, img_height) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ bewertung.image|raw }}"
````

Komponente **_Hausdetail_** _default.htm_: Die Code-Zeile ``src="{{ image.thumb(image_width,image_height) }}"`` muss druch folgenden Code ersetzt werden:
````
src="{{ image|raw }}"
````

Komponente **_Hausliste_** _default.htm_: Die Code-Zeile ``src="{{ haus.image.thumb(haus.image_width,haus.image_height) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ haus.image|raw }}"
````

Komponente **_Obj-Bewertungen_** _item.htm_: Die Code-Zeile ``src="{{ bewertung.image.thumb( img_width, img_height) }}"`` muss durch folgenden Code ersetzt werden:
````
src="{{ bewertung.image.thumb|raw }}"
````
- - -

## Upgrade 3.5.18
#### Dieses Update enthält eine neue Funktion für die Eigentümerlogin-Erweiterung.
Ab sofort ist es möglich, automatisierte Emails an den Eigentümer zu senden, sobald dieser über den Fewo-Verwalter für den Eigentümerlogin freigeschlatet oder die Login-Daten geändern wurden. Diese Funktion kann im Backend unter _Einstellungen -> Eigentümer-Einstellungen_ aktiviert werden. Die entsprechenden Mail-Vorlagen, können im Bereich der Mail-Vorlagen angepasst werden. Mehrsprachige Mail-Vorlagen sind möglich.
- - -

## Upgrade 3.5.15
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente Listenfilter default.htm: Die Code-Zeile ``$('#abreise').request('onDataChange');`` im Script-Bereich, muss durch folgenden Code ersetzt werden:
````
$('#abreise').request('onDataChange', {data: {dateChange: 1}});
````
- - -

## Upgrade 3.5.14
### Folgende Partialanpassungen für dieses Update 
Komponente Eigentümerdaten default.htm: Der komplette Code muss ersetzt werden durch:  
**WICHTIG! Anpassung nur notwendig, wenn das default.htm Partial für _Eigentümerdaten_ angepasst wurde!**
````
<div class="clearfix"></div>
<div class="eheader">
    <div class="enummer">{{ labels.enummer }} {{ nummer }}</div>
    {% if firma %}
    <div class="efirma">{{ labels.efirma }} {{ firma }}</div>
    {% endif %}
    <div class="ename">{{ labels.ename }} {{ vorname }} {{ name }}</div>
    <div class="float-right">
        <a href="#" data-request="onLogout">{{ btnlogout }}</a>
    </div>
</div>
<div class="edaten">
    <div id="exTab2" class="container col-md-12 p-0 float-left"> 
        <ul class="nav nav-tabs" role="tablist" id="edatenTab">
            {% if showabrechnung == 1 %}
                <li class="nav-item disabled" id="tab1"><a class="nav-link active" href="#1" data-toggle="tab" role="tab">{{ labels.tab1 }}</a></li>
            {% endif %}
            {% if showvorgaenge == 1 %}
                <li class="nav-item disabled" id="tab2"><a class="nav-link" href="#2" data-toggle="tab" role="tab">{{ labels.tab2 }}</a></li>
            {% endif %}
            {% if showobjekte %}
                <li class="nav-item disabled" id="tab3"><a class="nav-link" href="#3" data-toggle="tab" role="tab">{{ labels.tab3 }}</a></li>
            {% endif %}
            {% if showbelegen %}
                <li class="nav-item disabled" id="tab4"><a class="nav-link" href="#4" data-toggle="tab" role="tab">{{ labels.tab4 }}</a></li>
            {% endif %}
        </ul>
        <div class="tab-content" >
            {% if showabrechnung ==1 %}
                <div role="tabpanel" class="tab-pane active" id="1">
                    <table id="abrechnungen" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ labels.rechnungsnr }}</th>
                                <th>{{ labels.jahr }}</th>
                                <th>{{ labels.monat }}</th>
                                <th>{{ labels.datum }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            {% endif %}
            {% if showvorgaenge == 1 %}
                <div role="tabpanel" class="tab-pane" id="2">
                    <table id="vorgaenge" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ labels.vorgjahr }}</th>
                                <th>{{ labels.vorgdatum }}</th>
                                <th>{{ labels.vorgart }}</th>
                                <th>{{ labels.vorganreise }}</th>
                                <th>{{ labels.vorgabreise }}</th>
                                <th>{{ labels.vorgtage }}</th>
                                <th>{{ labels.vorgobjekt }}</th>
                                <th>{{ labels.vorgobjid }}</th>
                                <th>{{ labels.vorgerwachsene }}</th>
                                <th>{{ labels.vorgkinder }}</th>
                                <th>{{ labels.vorgobjpreis }}</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>{{ labels.vorgjahr }}</th>
                                <th>{{ labels.vorgdatum }}</th>
                                <th>{{ labels.vorgart }}</th>
                                <th>{{ labels.vorganreise }}</th>
                                <th>{{ labels.vorgabreise }}</th>
                                <th>{{ labels.vorgtage }}</th>
                                <th>{{ labels.vorgobjekt }}</th>
                                <th>{{ labels.vorgobjid }}</th>
                                <th>{{ labels.vorgerwachsene }}</th>
                                <th>{{ labels.vorgkinder }}</th>
                                <th>{{ labels.vorgobjpreis }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            {% endif %}
            {% if showobjekte %}
                <div role="tabpanel" class="tab-pane" id="3">
                    <table id="objekte" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ labels.objnr }}</th>
                                <th>{{ labels.objtitel }}</th>
                                <th>{{ labels.objart }}</th>
                                <th>{{ labels.objpers }}</th>
                                <th>{{ labels.objqm }}</th>
                                <th>{{ labels.objint }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            {% endif %}
            {% if showbelegen %}
                <div role="tabpanel" class="tab-pane" id="4">
                    <form class="eigenbelegung_form" method="post" data-request="{{ __SELF__ }}::onBelegung">
                        <div class="bel_objekt">
                            <div class="label label_objektauswahl">{{ labels.belobjekt }}</div>
                            <select id="ctrl_objekt" class="select frm_objekt" name="objekt" data-request="{{ __SELF__ }}::onObjektChange" style="width:300px;">
                                {% for key, obj in belobjekte %}
                                    <option value="{{ key }}">{{ obj|raw }}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <div id="belegung"></div>
                    </form>
                </div>
            {% endif %}
        </div>
    </div>
</div>
<script>
    function format(d) {
        // `d` is the original data object for the row
        var subtable = '<table class="display" cellspacing="2" border="0" style="margin-left:50px;width:90%;">'+
            '<thead>' +
            '<tr>';
        {% if showgastdaten %}
            {% if showGastVorname %}subtable += '<th style="padding-left:20px;">{{ labels.vorgvorname }}</th>';{% endif %}
            {% if showGastName %}subtable += '<th style="padding-left:20px;">{{ labels.vorgname }}</th>';{% endif %}
            {% if showGastEmail %}subtable += '<th style="padding-left:20px;">{{ labels.vorgmail }}</th>';{% endif %}
        {% endif %}
        {% if showGastHinweis %}subtable += '<th style="padding-left:20px;">{{ labels.memo }}</th>';{% endif %}
        {% if showGastEigentuemerhinweis %}subtable += '<th style="padding-left:20px;">{{ labels.ehinweis }}</th>';{% endif %}
        subtable += '</tr>' +
            '</thead>' +
            '<tr>';
        {% if showgastdaten %}
            {% if showGastVorname %}subtable += '<td style="padding-left:20px;">'+d.vorname+'</td>';{% endif %}
            {% if showGastName %}subtable += '<td style="padding-left:20px;">'+d.name+'</td>';{% endif %}
            {% if showGastEmail %}subtable += '<td style="padding-left:20px;">' + d.mail + '</td>';{% endif %}
        {% endif %}
        {% if showGastHinweis %}subtable += '<td style="padding-left:20px;">' + d.memo + '</td>';{% endif %}
        {% if showGastEigentuemerhinweis %}subtable += '<td style="padding-left:20px;">' + d.ehinweis + '</td>';{% endif %}
        subtable += '</tr>';
        {% if showleistung %}
            var length = JSON.parse(d.leistungen).length;
            if(length > 0) {
                subtable += '<tr>';
                {% if showgastdaten %}
                    subtable += '<td colspan="5">';
                {% else %}
                    subtable += '<td colspan="2">';
                {% endif %}
                subtable += '<table id="leistungen" class="display" style="width:100%; margin-top:10px;">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>{{ labels.lnr }}</th>' +
                    '<th>{{ labels.ltitel }}</th>' +
                    '<th class="dt-center">{{ labels.lanz }}</th>' +
                    '<th class="dt-right">{{ labels.lepreis }}</th>' +
                    '<th class="dt-right">{{ labels.lsumme }}</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';
                $.each(JSON.parse(d.leistungen), function (index, value) {
                    subtable += '<tr>';
                    subtable += '<td>' + value.nr + '</td>';
                    subtable += '<td>' + value.text + '</td>';
                    subtable += '<td class="dt-center">' + value.anz + '</td>';
                    subtable += '<td class="dt-right">' + value.epreis + '</td>';
                    subtable += '<td class="dt-right">' + value.summe + '</td>';
                    subtable += '</tr>';
                });
                subtable += '</tbody></table>' +
                '</td>' +
                '</tr>';
            }
        {% endif %}
        subtable += '</table>';
        return subtable;
    }

    function formatAbr(d) {
        var subtable = '<table class="display" cellspacing="2" border="0" style="margin-left: 50px; width: 90%;">' +
            '<thead>' +
            '<tr>' +
            '<th>{{ labels.abrechnung }}</th>' +
            '<th>{{ labels.provision }}</th>' +
            '<th>{{ labels.wartung }} 1</th>' +
            '<th>{{ labels.wartung }} 2</th>' +
            '<th>{{ labels.wartung }} 3</th>' +
            '<th>{{ labels.wartung }} 4</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '<tr>' +
            '<td><button data-attach-loading data-request-data="file: \'' + d.abr + '\', fileid: {{ nummer}}" data-request="{{ __SELF__ }}::onDownload">Download</button></td>' +
            '<td><button data-attach-loading data-request-data="file: \'' + d.prov + '\', fileid: {{ nummer}}" data-request="{{ __SELF__ }}::onDownload">Download</button></td>';
        $.each(d.wartung, function (index, value) {
            subtable += '<td><button data-attach-loading data-request-data="file: \'' + value + '\', fileid: {{ nummer}}" data-request="{{ __SELF__ }}::onDownload">Download</button></td>';
        });

        subtable += '</tr>' +
            '</tbody>' +
            '</table>';

        return subtable;
    }

	$(document).ready(function() {
        $('#ctrl_objekt').select2({});

        {% if showabrechnung ==1 %}
            var abrData = {{ abrechnungen|raw }};

            var abrTable = $('#abrechnungen').DataTable({
                bFilter: true,
                language: { {{ scriptlang|raw}} },
                order: [[2, 'asc']],
                displayLength: 15,
                data: abrData,
                columns: [
                    {
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {'data': 'rechnr'},
                    {'data': 'jahr'},
                    {'data': 'monat'},
                    {'data': 'datum'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        width: '30px',
                        serachable: false,
                        sortable: false,
                    },
                    {
                        targets: 1,
                        width: "10px",
                    },
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    api.column(0, {page: 'current'}).data().each(function(group, i) {
                        if (last !== group) {
                            if (i['jahr'] == group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="9">' + group + '</td></tr>'
                                );
                                last = group;
                            }
                        }
                    });
                },
            });

            // Order by the grouping
            $('#abrechnungen tbody').on('click', 'tr.group', function() {
                var currentOrder = abrTable.order()[0];
                if (currentOrder[0] === 0 && currentOrder[1] === 'asc') {
                    abrTable.order([0, 'desc'], [1, 'desc']).draw();
                } else {
                    abrTable.order([0, 'asc'], [1, 'desc']).draw();
                }
            });

            $('#abrechnungen tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = abrTable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(formatAbr(row.data())).show();
                    tr.addClass('shown');
                }
            });
        {% endif %}

        {% if showvorgaenge == 1 %}
            var vorgData = {{vorgaenge|raw}};

            $('#vorgaenge thead tr').clone(true).addClass('filters').appendTo('#vorgaenge thead');

            // Vorgaenge ***********************************
            var table = $('#vorgaenge').DataTable({
                rowReorder: true,
                language: { {{ scriptlang|raw}} },
                data: vorgData,
                columns: [
                    {
                        className:      'details-control',
                        orderable:      false,
                        data:           null,
                        defaultContent: ''
                    },
                    {"data": "jahr"},
                    {"data": "datum"},
                    {"data": "art"},
                    {"data": "anreise"},
                    {"data": "abreise"},
                    {"data": "tage"},
                    {"data": "objekt"},
                    {"data": "objid"},
                    {"data": "erwachsene"},
                    {"data": "kinder"},
                    {"data": "objpreis", render: $.fn.dataTable.render.number( '.', ',', 2,'', ' €' )},
                ],
                columnDefs: [
                    {
                        targets: 1,
                        width:"30px",
                        visible: true,
                        searchable: true,
                        sortable: true,
                    },
                    {
                        targets: 3,
                        sortable: false,
                        searchable: false,
                        className: "dt-center",
                        render: function(data,type,row)
                        {
                            var color= '#000';
                            if(data == 'B')
                                color = 'red';
                            if(data == 'A')
                                color = '#e6e600';
                            if(data == 'BL')
                                color = '#00b300';
                            return '<span style="font-weight:bold;color:' + color +'">' + data +'</span>';
                        }
                    },
                    {
                        targets: 4,
                        sortable: true,
                        searchable: true,
                        type: 'de_date',
                    },
                    {
                        targets: 5,
                        sortable: true,
                        searchable: true,
                        type: 'de_date',
                    },
                    {
                        targets: 6,
                        width: "30px",
                        sortable: false,
                        searchable: false,
                        className: "dt-center"
                    },
                    {
                        targets: 8,
                        width: "30px",
                        sortable: false,
                        searchable: true,
                        className: "dt-center",
                    },
                    {
                        targets: 9,
                        sortable: false,
                        searchable: false,
                        className: "dt-center"
                    },
                    {
                        targets: 10,
                        sortable: false,
                        searchable: false,
                        className: "dt-center"
                    },
                    {
                        targets: 11 ,
                        className: "dt-right"
                    },
                ],
                order: [[1, 'desc'], [4, 'desc']],
                displayLength: {{ itemsProSeite }},
                dom: 'lfrtip',
                buttons: [
                    'csv', 'print'
                ],
                orderCellsTop: true,
                initComplete: function () {
                    var api = this.api();
                    api.columns().eq(0).each(function (colIdx) {
                        var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                        var title = $(cell).text();
                        if(colIdx > 0 && colIdx !== 3 && colIdx !== 9  && colIdx !== 6)
                            $(cell).html('<input type="text" size="8" placeholder="' + title + '" />');
                        else
                            $(cell).html('&nbsp;');
                        $('input', $('.filters th').eq($(api.column(colIdx).header()).index())).off('keyup change').on('keyup change', function (e) {
                            e.stopPropagation();
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})';
                            var cursorPosition = this.selectionStart;
                            if (colIdx !== 8) {
                                api.column(colIdx).search(
                                    this.value !== ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value !== '',
                                    this.value === ''
                                ).draw();
                            } else {
                                api.column(colIdx).search(
                                    this.value !== ''
                                        ? '\\b' + $(this).val() + '\\b'
                                        : '',
                                    this.value !== '',
                                    this.value === ''
                                ).draw();
                            }
                            $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                        });
                    });
                },
                drawCallback: function (settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var last = null;
                    var totale = [];
                    totale['Totale'] = [];
                    var groupid = -1;
                    var subtotale = [];
                    var columns = [1];
                    var columns1 = 9, s = 0;
                    var colNo = [10];
                    var count = 0, svalue = [];
                    for (var c = 0; c < columns.length; c++) {
                        colNo = columns[c];
                        api.column(colNo, { page: 'current' }).data().each(function(group, i) {
                            if (last !== group) {
                                groupid++;
                                $.each(api.rows({ page: 'current' }).data(), function(index, row) {
                                    if (row['jahr'] === group) {
                                        var addSum = false;
                                        $.each(row, function (index2, val2) {
                                            if(index2 === 'art' && val2 === 'B')
                                                addSum = true;
                                            if (index2 === 'objpreis' || index2 === 'tage' || index2 === 'erwachsene' || index2 === 'kinder') {
                                                if (typeof subtotale[groupid] == 'undefined')
                                                    subtotale[groupid] = [];
                                                if (typeof subtotale[groupid][index2] == 'undefined') {
                                                    subtotale[groupid][index2] = 0;
                                                    if (index2 === 'kinder')
                                                        subtotale[groupid]['kkinder'] = 0;
                                                }
                                                var valCol = 0;
                                                if (index2 === 'kinder') {
                                                    var kinder = val2.split("/");
                                                    subtotale[groupid][index2] = +parseFloat(subtotale[groupid][index2] + parseFloat(kinder[0])).toFixed(2);
                                                    subtotale[groupid]['kkinder'] = +parseFloat(subtotale[groupid]['kkinder'] + parseFloat(kinder[1])).toFixed(2);
                                                } else {
                                                    valCol = Number(val2);
                                                    if(addSum === true)
                                                        subtotale[groupid][index2] = +parseFloat(subtotale[groupid][index2] + valCol).toFixed(2);
                                                }
                                            }
                                        });
                                    }
                                });
                                svalue.push(count);
                                last = group;
                                count = i;
                            } else {
                                count = count + 1;
                            }
                        });
                    }
                    if (svalue.length > groupid) {
                        svalue.push(count);
                        groupid++;
                    }
                    for (var c = 0; c < svalue.length-1;) {
                        var colNo2 = columns[c];
                        api.column(colNo2, {page: 'current'}).data().each(function(group, i) {
                            var  subtd = '';
                            subtd = "Summen " + group + " : "+ $.fn.dataTable.render.number('.', ',', 2,'',' €').display(subtotale[s]['objpreis']);
                            var objsumme = $.fn.dataTable.render.number('.', ',', 2,'',' €').display(subtotale[s]['objpreis']);
                            var tage = $.fn.dataTable.render.number('.', ',', 0).display(subtotale[s]['tage']);
                            var erw = $.fn.dataTable.render.number('.', ',', 0).display(subtotale[s]['erwachsene']);
                            var kind = $.fn.dataTable.render.number('.', ',', 0).display(subtotale[s]['kinder']);
                            var kkind = $.fn.dataTable.render.number('.', ',', 0).display(subtotale[s]['kkinder']);
                            if (i == svalue[c + 1]) {
                                $(rows).eq(i).after(
                                    '<tr class="group group-end"><td colspan="6">Summen (B) ' + group + '</td><td class="dt-center">' + tage + '</td><td></td><td></td><td class="dt-center">' + erw + '</td><td class="dt-center">' + kind + '/' + kkind + '</td><td class="dt-right">' + objsumme + '</td></tr>'
                                );
                                s++;
                                c++;
                            }
                        });
                    }
                }
            });
            // Add event listener for opening and closing details
            $('#vorgaenge tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
        {% endif %}

        {% if showobjekte %}
            var objData = {{ objekte|raw}};
            var tableObjekte = $('#objekte').DataTable({
                rowReorder: true,
                language: { {{scriptlang | raw}}},
                data:objData,
                columns:[
                     {
                        className: 'details-objekte',
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {"data": "id"},
                    {"data": "titel"},
                    {"data": "art"},
                    {"data": "pers"},
                    {"data": "qm",render: $.fn.dataTable.render.number( '.', ',', 2,'',' qm' )},
                    {"data": "intern"},
                ],
                columnDefs: [
                    {
                        targets: 1,
                        visible: true,
                        searchable: true,
                    },
                    {
                        targets: 4,
                        sortable: false,
                        searchable: false,
                        className: "dt-center"
                    },

                    {
                        targets: 6 ,
                        className: "dt-center"
                    },
                ],
                order:[[1, 'asc']],
                displayLength:15,
                dom:'Bfrtip',
                buttons:['csv', 'print']
            });
        {% endif %}
    });
</script>
````
####**In der Eigentümer-Komponente können nun weitere Einstellungen für die Anzeige der Daten für die Vorgangsliste festgelegt werden.**


- - -

## Upgrade 3.5.13
**WICHTIG! Durchführung nur notwendig, wenn _Sync Feondi_ in den Fewo-Einstllungen aktiviert ist.**  
Dieses Update enthält Verbesserungen für die Benutzung von _Sync Feondi_ im Backend. Wenn Sie den Sync für Feondi 
in den Fewo-Einstellungen aktiviert haben, müssen alle Belegungen im Fewo-Verwalter zu Feondi erneut gesendet werden.  
Gehen Sie dazu im Fewo-Verwalter auf _Programm_ > _Internetschnittstellen_ > _Fewo-Verwalter Proxy (Feondi)_ > _alle Belegungen senden_.
Warten Sie, bis die Übertragung abgeschlossen ist.
- - -

## Upgrade 3.5.7
Behebung einer Sicherheitslücke im Bereich Listensortierung (credits @Daniel Blumhagen für die Meldung der Lücke)

**Zur kurzfristigen Installation des Updates wird dringend geraten!**
- - -

## Upgrade 3.5.5
### Achtung: Im Falle der Verwendung unseres Eigentümerlogins, müssen alle notwendigen Abrechnungen erneut vom Fewo-Verwalter für den Eigentümerlogin bereitgestellt werden. Dies kann wie folgt erfolgen:
Gehen Sie im Fewo-Verwalter in den Bereich _Finanzen_. Klicken Sie nun auf den Button _Abrechnungsliste_. 
Markieren Sie alle Abrechnungen, die für den Eigentümerlogin bereitgestellt werden sollen. Dies können Sie entweder mit gedrückter Strg-Taste und anklicken der jeweiligen Abrechnung machen oder indem Sie die oberste zu sendende Abrechnung anklicken, die Umschalt-Taste (Großschreib-Taste) drücken und gedrückt halten und dann die unterste Abrechnung mit der Maus anklicken (beides Windows-Standard für die Mehrfach-Auswahl in Listen wenn zulässig). Anschließend klicken Sie auf den Button _in Eigentümerlogin bereitstellen_.

### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente Bild aus Stammdaten (Image) default.htm: Das ``src``-Attribut aller ``img``-Tags muss wie folgt definiert werden:
````
src="{{ image|raw }}"
````
- - -

## Upgrade 3.5.4
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente Buchungsmaske default.htm: Folgende Code-Zeile muss innerhalb des div-Elements mit der Klasse ``class="book-22"``
ganz unten (unterhalb von ``id="error-anreise"``) eingefügt werden:
````
<div id="belplanScript"></div>
````

###Optionale Anpassungen
Diese Anpassungen sind **optional**.  
Folgende Felder können in der Zusammenfassung der Buchungsmaske (Partials > Buchungsmaske/zusammen.htm) ausgegeben werden:

Ausgabe Gast-Titel. Label Platzhalter kann in der Komponenete gesetzt werden.
````
<div class="label">{{ labels.titel }}</div>
<div class="zusammenfassung titel">{{ data.titel }}</div>
````

Ausgabe Anzahl der gewählten Nächte. Label Platzhalter kann in der Komponenete gesetzt werden.
````
<div class="label">{{ labels.naechte }}</div>
<div class="zusammenfassung naechte">{{ data.naechte }}</div>
````

Ausgabe Objektpreis. Label Platzhalter kann in der Komponenete gesetzt werden.
````
<div class="label">{{ summen.objektpreis }}</div>
<div class="zusammenfassung objektpreis">{{ data.objektpreis }}</div>
````
- - -

## Upgrade 3.4.38
### Folgende Partialanpassungen sind für dieses Update notwendig
Komponente Objekt OpenStreetMap (ObjektMap) default.htm: Kompletten Code ersetzen durch:
````(Twig)
<div id="fewo-liste" class="col-lg-12 float-left">
    <div id="fewo-listmap">
        {% if keineObjekte %}
            <div><p>{{ keineTrefferLabel }}</p></div>
        {% else %}
            <div id="map" class="fewo-listmap" style="height:600px;"></div>
            <script>
                jQuery(document).ready(function() {
                    let tiles = L.tileLayer('{{maptype}}', {
                        maxZoom: 18,
                        scrollWheelZoom: false,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>, Service <a href="https://www.fewo-verwalter.de" target=_blank">Fewo-Verwalter</a>'
                    });
                    let latlng = L.latLng({{mapcenterlat}}, {{mapcenterlng}})
                    let map = L.map('map', {
                        center: latlng,
                        zoom: 14,
                        layers: [tiles],
                        {% if fullscreen %}
                            fullscreenControl: true,
                            fullscreenControlOptions: {
                                title: "Vollbildansicht",
                                titleCancel: "Normalansicht"
                            },
                        {% endif %}
                    });
                    let markers = L.markerClusterGroup({ chunkedLoading: true });
                    let markerList = [];
                    {% for marker in maps %}
                        var title = '<div class="map_marker"><img src="{{ marker.image|raw }}"><div class="title">{{ marker.titel }}</div><div class="title">{{ marker.strasse|raw }}</div><div class="title">{{ marker.plz }} {{ marker.ort|raw }}</div><div class="btn btn-success btn-sm fewo-btndetail"><a href="{{ marker.href }}">{{ btnDetail|raw }}</a></div></div>';
                        var marker = L.marker(L.latLng({{ marker.lat}}, {{marker.long}}), { title: '{{ marker.titel }}' });
                        marker.bindPopup(title).on('click', clickZoom);
                        markerList.push(marker);
                    {% endfor %}
                    markers.addLayers(markerList);
                    map.addLayer(markers);
                    try {
                        var bounds = markers.getBounds();
                        if (bounds) {
                            map.fitBounds(bounds);
                        }
                    } catch(err) {
                        // pass
                    }
                    map.on('mouseout',function() {
                        map.scrollWheelZoom.disable();
                    });
                    function clickZoom(e) {
                        map.setView(e.target.getLatLng());
                    }
                });
            </script>
        {% endif %}
    </div>
</div>
````
> **WICHTIG:** Gegebenenfalls muss bereits individuell angepasster Code in den obenstehenden Code erneut integriert werden.  
- - -

## Upgrade 3.4.36
### Folgende Partialanpassungen sind für dieses Update notwendig
Angebote default.htm: Code ``{{ listitemcss }}`` hinter der Klasse _fewo-item_ einfügen:
````
<div class="fewo-item {{ listitemcss }}">
````
- - -

## Upgrade 3.4.32
### Folgende Partialanpassungen sind für dieses Update notwendig
Listenfilter default.htm: Im Script innerhalb der Funktion ``$(document).ready(function() {});`` unten folgenden Code einfügen:
````
picker.bind('datepicker-clear', function() {
    $.request('onDeleteDate');
});
````
- - -

## Upgrade 3.4.20
### Optionale Anpassung: Nur notwendig, wenn Ausgabe des Youtube-Links auf der Listenseite erwünscht ist
Objektliste default.htm: Folgende Codezeile innerhalb des ``<article>``-Elemets an der gewünschten Stelle einfügen:
````
{% if objekt.YoutubeLink %}<div class="fewo-youtubeLink">{{ objekt.YoutubeLink|raw }}</div>{% endif %}
````
- - -

## Upgrade 3.4.18
**WICHTIG!**  
Bitte wenden Sie sich VOR der Aktivierung von _Sync Feondi_ an unseren Support, damit er diesen Kanal für Sie aktivieren kann!  
Danach aktivieren Sie die Funktion _Sync Feondi_ im Backend unter _Einstellungen_ > _FEWO Einstellungen_.  
Damit die Funktion _Sync Feondi_ benutzt werden kann, ist ein erneutes Daten senden vom Fewo-Verwalter an Feondi notwendig.  
Gehen Sie dazu im Fewo-Verwalter auf _Programm_ > _Internetschnittstellen_ > _Fewo-Verwalter Proxy (Feondi)_ > _alle Daten senden_.
Warten Sie, bis die Übertragung abgeschlossen ist.
- - -

## Upgrade 3.4.13
### WICHTIG! Bitte lösen Sie nach dem Update "alle Belegungen senden" im Fewo-Verwalter aus.
### Folgende Partialanpassungen sind für dieses Update notwendig

Buchungsmaske mitreisende-variant2.htm und mitreisende.htm: Im Script ``{{ mitreisender.mitgeb2 }}`` ändern zu:
````
{{ mitreisender.mitgeb }}
````
- - -

## Upgrade 3.4.8
### Folgende Partialanpassungen sind für dieses Update notwendig
Buchungsmaske default.htm und variant2.htm: Folgenden Code im Script-Teil unterhalb von ``var customArrowNext = ' ';`` einfügen und  
Preisrechner default.htm: Folgenden Code im Script-Teil unterhalb von ``var customArrowNext = ' ';`` einfügen.
````
var wechselleiste = '{{ wechselleiste }}';
var wechselleisteStart = {{ wechselleisteStart }};
````
HINWEIS: Nach Durchführung des Updates und der Anpassungen muss gegebenenfalls der Browser-Cache geleert werden.
- - -

## Upgrade 3.4.0
### Folgende Partialanpassungen sind für dieses Update notwendig
Im Falle der Verwendung einer Karte auf der Listenseite, muss das komplette default.htm Partial der 
Listenseite überarbeitet werden. Schauen Sie dazu in das default.htm Partial der Komponente.

> ### Notwendige Anpassungen in der Übersicht 
> - Um das div mit der ID ``fewo-listmap`` eine if else Anweisung schreiben ``{% if mapOption == true %}``
> - In den else-Teil das script für GoogleMaps einfügen
> - Im article-Tag muss folgender Code eingefügt werden: ``{% if showmap == true %}onclick="onListSelected({{ objekt.id }})"{% endif %}>``
> - Das div nach ``<article>`` muss mit der Klasse ``class="mapObjekt"`` erweitert werden
> - Um das div mit der Klasse ``fewo-map`` eine if else Anweisung schreiben ``{% if mapOption == true %}``
> - In den else-Teil den das Script für GoogleMaps einfügen

Bild aus Stammdaten default.htm: Das letzte und das drittletzte ``<img>``-Tag ersetzen durch folgenden Code:
````
<img src="{{ image|raw }}" alt="{{ image.title }}" title="{{ image.title }}">
````
- - -

## Upgrade 3.3.8
### Folgende Partialanpassungen sind für dieses Update notwendig
Objekliste default.htm: img-Tag im div-Container mit der Klasse ``fewo_image`` durch folgenden Code ersetzen:
````
<img src="{{ objekt.image|raw }}" alt="{{ objekt.image.title }}" title="{{ objekt.image.title }}"/>
````

Maps default.htm: Folgende Code-Zeilen unterhalb von ``var color = '{{ color }}';`` einfügen:
````
var isInTab = false;
var selectedTab = '';
````
- - -

## Upgrade 3.3.6
### Folgende Partialanpassungen sind für dieses Update notwendig
Buchungsmaske default.htm: Folgenden Code unter die Zeile ``var dateplaceholder = '{{ dateplaceholder }}';`` einfügen und  
Preisrechner default.htm: Folgenden Code unter die Zeile ``var zeitraum = '{{ ppzeitraum }}';`` einfügen:
````
var calClick = {{ calClick }};
````
- - -

## Upgrade 3.3.4
### Folgende Partialanpassungen sind für dieses Update notwendig  

Preisrechner default.htm: Folgenden Code über die Zeile ``// Datepicker settings`` einfügen:
````
var anreise = '{{ ppanreise }}';
var abreise = '{{ ppabreise }}';
var zeitraum = '{{ ppzeitraum }}';
````
- - -

## Upgrade 3.3.2

> ###Anpassungen Eigentümerlogin
> **Folgende Anpassungen sind nur notwendig, wenn Sie bereits einen Eigentümerlogin besitzen!**  
> - Melden Sie sich in Ihrem Hosting an
> - Wechseln Sie in das Hauptverzeichnis Ihrer OctoberCMS-Installation
> - Navigieren Sie in das Verzeichnis */plugins/xsigns*
> - Erstellen Sie eine Lokale Kopie des Ordners *owner* auf Ihren Rechner
> - Löschen Sie nun den Ordner *owner* in Ihrem Hosting

### Folgende Partialanpassungen sind für dieses Update notwendig  

SchemaOrg default.htm *aggregateRating*-Block ersetzen durch:  
````
{% if ratingcount > 0 %}
  "aggregateRating": {
    "@type": "AggregateRating",
    "bestRating": 5,
    "ratingValue": "{{ ratingvalue }}",
    "reviewCount": "{{ ratingcount }}",
    "worstRating": 1
  },
{% endif %}
````

Buchungsmaske default.htm und Preisrechner default.htm: Folgenden Code unter ``var todayInvalid = {{ todayno }};`` einfügen
````
var customArrowPrev = ' ';
var customArrowNext = ' ';
````
- - -

## Upgrade 3.3.1
### Folgende Partialanpassungen sind für dieses Update notwendig

Preisrechner default.htm: Kompletten script-Part ersetzen
````
<script type="text/javascript">
    {% if script1 %}
        var script1 = true;
    {% else %}
        var script1 = false;
    {% endif %}

    var datecompact = {{ datecompact }};

    {% if felder.tagein %}
        var tagein = true;
    {% else %}
        var tagein = false;
    {% endif %}

    // Datepicker settings
    var separator = ' bis ';
    var selectForward = true;
    var autoClose = true;
    var showArrow = {% if datecompact == 1 %} false {% else %} true {% endif %};
    var format = 'DD.MM.YYYY';
    var startOfWeek = 'monday';
    var startDate = '{{ mindate|raw}}';
    var minDays = 2;
    var endDate = '{{ lastday }}';
    var showShortcuts = true;
    var shortcuts = {'delete':true};
    var showLegend = true;
    var saisons = {{ saisons|raw }};
    var blocked = {{ blockeddates|raw }};
    var posright = false;
    var language = '{{ callang }}';
    var showTopbar = true;
    var todayInvalid = {{ todayno }};
</script>

````
(Optional) Preisrechner default.htm: Innerhalb des div's mit der ID fewo_summe folgenden Code einfügen
````
<div class="label">{{ pobjektpreislabel }}</div><div id="objektpreis">{{ objektpreis }}</div>
<div class="label">{{ pnebenkostenlabel }}</div><div id="nebenkosten"></div>
````

Buchungsmaske default.htm: Kompletten script-Part ersetzen
````
<script type="text/javascript">
	var datecompact = {{ datecompact }};
	var anreise = '{{ anreise }}';
	var abreise = '{{ abreise }}';
	var dateplaceholder = '{{ dateplaceholder }}';

	{% if anreise and abreise %}
		var perwachsene = '{{ perwachsene }}';
		var pkinder = '{{ pkinder }}';
	{% else %}
		var perwachsene = 0;
		var pkinder = 0;
	{% endif %}

	// Datepicker settings
	var separator = '';
	var selectForward = true;
	var autoClose = true;
	var format = 'DD.MM.YYYY';
	var alwaysOpen = false;
	var showShortcuts = true;
	var showLegend = true;
	var shortcuts = {'delete':true};
	var startOfWeek = 'monday';
	var startDate = '{{ mindate|raw}}';
	var minDays = {{ mindays|raw}};
	var endDate = '{{ lastday }}';
	var saisons = {{ saisons|raw }};
	var blocked = {{ blockeddates|raw }};
	var language = '{{ lang }}';
	var showTopbar = true;
	var todayInvalid = {{ todayno }};
</script>
````

Buchungsmaske payment.htm: kompletten Code ersetzen
````
<div class="clearfix"></div>
<div id="payh"></div>
<script>
    var host = "{{ host }}";
    var checkoutId;

    var stageAuthentication = {
        "authentication.entityId": "{{ entityId }}",
        "authentication.password": "{{ password }}",
        "authentication.userId": "{{ userid }}",
    }
    var createCheckout = {
        "amount": "{{ sum }}",
        "currency": "{{ currency }}",
        "paymentType": "DB",
        "descriptor": "{{ buid }}",
        "merchantTransactionId": "{{ transactionid }}",
        "customParameters[SHOPPER_customerId]": "{{ buid }}",
    }
    for(var p in stageAuthentication)
        createCheckout[p]=stageAuthentication[p];

    $.support.cors = true;
    $.ajaxSetup({cache: true});
    $.post(host + "/v1/checkouts", createCheckout )
        .then(function(response) {
            checkoutId = response.id;
            var Respi ="{{ ResultUrl|raw }}" + checkoutId;
            $("#payh").append("<div class=\"container\" style=\"display:block\"><form class=\"paymentWidgets\" action=\"" + Respi +"\">{{ brands }}</form></div>");
            $.getScript(host + "/v1/paymentWidgets.js?minified=false&checkoutId=" + checkoutId);
        });

    var wpwlOptions = {
        style: "plain",
        locale:"de",
    };
</script>
````

Belegungsplan: default.htm: Kompletten Code ersetzen
````

<div id="BelPlan" class="fewo_detail_buchungsplan {% if isClickable == 1 %} isClickable {% endif %}">
    {% if selectbox %}
    <div class="selector">
        {% if isClickable == 1 %}
            <select class="ctrlSaisonSelect" name="calSelector">
                <!--<select class="ctrlSaisonSelect" name="calSelector" data-request-data="calid: {{ calobjid }}, caloffset: {{ caloffset }}" data-request="{{ __SELF__ }}::onSelectorChange">-->
                {% set i=0 %}}
                {% for monat in monate %}
                    <option value="{{i}}">{{ monat }}</option>
                    {% set i = i +1 %}
                {% endfor %}
            </select>
        {% else %}
            <select class="ctrlSaisonSelect" name="calSelector" data-request-data="calid: {{ calobjid }}, caloffset: {{ caloffset }}" data-request="{{ __SELF__ }}::onSelectorChange">
                {% set i=0 %}}
                {% for monat in monate %}
                    <option value="{{i}}">{{ monat }}</option>
                    {% set i = i +1 %}
                {% endfor %}
            </select>
        {% endif %}
    </div>
    {% endif %}

    {% if isClickable == 1 %}
        <div id="calbtnleft_{{ calobjid }}"><button class="btn-left ctrlCalPrev">{{ btnleft }}</button></div>
    {% else %}
        <div id="calbtnleft_{{ calobjid }}"><button class="btn-left ctrlCalPrev" data-request-data="calid: {{ calobjid }}, caloffset: {{ caloffset }}" data-request="{{ __SELF__ }}::onBtnLeft">{{ btnleft }}</button></div>
    {% endif %}
<div id="ctrlBookingPlans_{{ calobjid }}" class="fewo_buchungsplan">
{{ belplan|raw }}
</div>
    {% if legendeshow %}
        <div class="belplan-legende"> {{ legende|raw }}</div>
    {% endif %}

    {% if isClickable %}
        <div id="calbtnright_{{ calobjid }}"><button class="btn-right ctrlCalNext">{{ btnright }}</button></div>
    {% else %}
        <div id="calbtnright_{{ calobjid }}"><button class="btn-right ctrlCalNext" data-request-data="calid: {{ calobjid }}, caloffset: {{ caloffset }}" data-request="{{ __SELF__ }}::onBtnRight">{{ btnright }}</button></div>
    {% endif %}
</div>


{% if isClickable == 1 %}
    {{ zeitleiste|raw }}
    <button onclick="Belplan.loescheAuswahl();">Auswahl löschen</button>
    <script>
        var calid = '{{ calid }}';
        var caloffset = '{{ caloffset }}';

        $(document).ready(function () {
            Belplan.initForm();
        });
    </script>
{% endif %}
````

Objektbewerten default.htm: Folgenden Code unter der Zeile ``$(document).ready(function() {`` einfügen
````
{% if hasNoOptions %}
    $('#inlinebewertung').on('click', function(e) {
        alert('Keine Bewertungsoptonen gefunden!!!\n\nBitte legen Sie mindestens eine Bewertungsoption im Fewo-Verwalter an.');
        e.preventDefault();
    });
{% endif %}
````
- - -

## Upgrade 3.3.0
- Objekt-Sortierung Reihenfolgen angepasst
- Problem in Sortierung, konnte nicht nach FewoVerwalter-Sortierung sortieren
- Problem im Datepicker, wenn heute nicht wählbar, funktionierte Lückenbuchung nicht mehr, Partialanpassung notwendig!

Partial Buchungsmaske/default.htm und Preisrechner/default.htm anpassen und folgenden Code an der unten kommentierten Stelle hinzufügen: ```` todayInvalid: {{ todayno }}, ````

````
var picker = $(dateComponent).dateRangePicker(
{
    startDate: new Date(),
    separator: '',
    selectForward: true,
    autoClose:true,
    format: 'DD.MM.YYYY',
    alwaysOpen:true,
    showShortcuts: true,
    showLegend:true,
    shortcuts: {'delete':true},
    startOfWeek: 'monday',
    startDate: '{{ mindate|raw}}',
    minDays: {{ mindays|raw}},
    endDate: '{{ lastday }}',
    saisons: {{ saisons|raw }},
    blocked: {{ blockeddates|raw }},
    language: '{{ lang }}',
    showTopbar:false,

    // -- Nachfolgende Zeile hier einfügen -- //
    todayInvalid: {{ todayno }},

    beforeShowDay: function(t)
    {
        if(this.blocked.indexOf(moment(t).format('YYYY-MM-DD'),0) > -1)
            valid=false;
        else
            valid = true;
        var _class = '';

        var _tooltip = valid ? '' : 'belegt';
        return [valid,_class,_tooltip];
    },
    setValue: function(s,from,to)
    {
        $('#ctrl_anreise').val(from);
        $('#ctrl_abreise').val(to);
        if(to)
            $('#ctrl_abreise').request('onAbreiseChange');
    }
});
````
- - -

##Upgrade 3.2.9
- Fehlerbehebungen
- Performance Verbesserungen
- - -

##Upgrade 3.2.8
Anpassung von default.htm der Map-Komponente.<br>
Aktuellen Code durch folgenden Code ersetzen:
````
<!-- Map -->
{% if mapDienst == 'leafletMap' %}
    <div id="mapid" class="fewo-objektmap " style="height:500px;"></div>
    <script type="text/javascript">
        var fullscreen = false;
        {% if fullscreen %}
            fullscreen = true;
        {% endif %}

        var showcircle = false;
        {% if showcircle %}
            showcircle = true;
        {% endif %}

        var centerlat = {{ centerlat }};
        var centerlong = {{ centerlong }};
        var leafletMap = '{{ map }}';
        var latitude = {{ latitude }};
        var longitude = {{ longitude }};
        var color = '{{ color }}';
    </script>
{% else %}
    <div style="height: {{ mapHeight }}px;" id="map"></div>
    <script type="text/javascript">
        var fullscreen = {{ googleFullscreen ? 'true' : 'false' }};
        var googleMapType = '{{ googleMapType }}';
        var mapZoom = {{ mapZoom }};
        var googleCenterlat = {{ centerlat }};
        var googleCenterlong = {{ centerlong }};
        // var marker_img = {{ marker_img }};
        var marker_img = '{{ marker_img }}';

        var use_marker = false;
        {% if use_marker %}
            use_marker = true;
        {% endif %}
    </script>
{% endif %}
````

Anpassung von default.htm der Objekttextsuche-Komponente.<br>
Folgenden Code unter ```` showNoResults: false, ```` einfügen:
````
fields: {
    title : 'title',
    description: ''
},
searchFields: [
    'description',
],
````
- - -

##Upgrade 3.2.7
- Bug im Zahlungsmodul, Fehlerhafte Zuordnung einer Tabelle
- - -

##Upgrade 3.2.6
- BUG im Zahlungsmodul, Datenbankabfrage war Fehlerhaft
- - -

##Upgrade 3.2.5
- BUG in Objektlisten, Sortierung hat Filter zurückgesetzt
- - -

##Upgrade 3.2.4
- BUG im Eigentümerbereich, Eigentümerbuchungen wurden nicht als Online-Vorgänge übertragen
- - -

##Upgrade 3.2.3
- Verbesserung bei der Übergabe von Zahlbeträgen zu Hobex (es werden immer zwei Dezimalstellen übergeben). Keine Anpassung von Partials notwendig. EN: Changed format for decimal places for the sum in Hobes requests. No changes in partials necessary.
- Fehler Lückenbuchung behoben
- Überprüfe ob Datei existiert
- - -

##Upgrade 3.2.2
- Anpassung der Angebote. Buchbar bei Tage vor Angebotsbeginn
- - -

##Upgrade 3.2.1
- Fehler in Objekttextsuche bei mehrsprachigen Seiten behoben. Keine Anpassung nötig.
- - -

##Upgrade 3.2.0
- Stamdatenausgabe um Kaution erweitert

Änderung der saisonzeit.htm im Header-Bereich der Tabelle

````
{% if kaution == 1 %}
<td class="fewo-head-kaution">{{ saisonlabels.kaution|raw }}</td>
{% endif %}
{% if anzahlung == 1 %}
<td class="fewo-saison-anzahlung">{{ saisonlabels.anzahlung|raw }}</td>
{% endif %}
````
Änderung der saisonzeit.htm im Ausgabe-Bereich der Tabelle

````
{% if kaution == 1 %}
<td class="fewo-saison-anreise">{{ saison.kaution }}</td>
{% endif %}
{% if anzahlung == 1 %}
<td class="fewo-saison-anreise">{{ saison.anzahlung }}</td>
{% endif %}
````

- Erweiterung der Objedetails um den Parameter Kaution

````
{{ Objektdetail.Kaution|raw }}
````
- - -

##Upgrade 3.1.9
- Mindestalter bei Buchungen.

Bei Ausgabe des Geburtsdatum als Pflichtfeld in der Buchungsmaske kann das Mindestalter des Hauptreisenden festgelegt werden.
Das Mindestalter kann im Fewo-Verwalter pro Objekt festgelegt weren.
- - -

##Upgrade 3.1.8
- Anpassung Hobex an Version 2. Einstellbar unter den Einstellungen.
- - -

##Upgrade 3.1.7
- Erweiterung des Image-Slider um die Auswahl Objekt-Slider oder Haus-Slider
- - -

##Upgrade 3.1.6
- Alias-Prüfung bei Objekten und Häusern, wenn Haus-Titel und Objekt-Titel identisch sind wird der Alias vom Haus geändert.
- - -

##Upgrade 3.1.3
- Automatisches löschen von temporären Buchungen im Zahlungsmodul
- neue Abschluss-Komponente

Abschluss-Komponente mit PLatzhaltern.

````
{% component 'Abschluss' %} = Name der Komponente(Verknüpfung)
{{ Abschluss.Gast.titel }}
{{ Abschluss.Gast.anrede }}
{{ Abschluss.Gast.vorname }}
{{ Abschluss.Gast.name }}
{{ Abschluss.Gast.strasse }}
{{ Abschluss.Gast.plz }}
{{ Abschluss.Gast.ort }}
{{ Abschluss.Anreise }}
{{ Abschluss.Abreise }}
{{ Abschluss.VorgArt }} = Buchung oder Angebot wie in der Komponente angegeben
{{ Abschluss.Tage }} = Länge des Vorgangs
{{ Abschluss.Erwachsene}}
{{ Abschluss.Kinder}}
{{ Abschluss.Kleinkinder}}
{{ Abschluss.Objektname}
{{ Abschluss.Objektnr }}
<a href="{{ Abschluss.LinkObjekt }}">zum Objekt</a>
````
- - -

##Upgrade 3.1.2
- Legende im Kalender hinzugefügt. Im Preisrechner und in der Buchungsmaske (default.htm) den Parameter 'showLegend: true,' unter 'showShortcuts: true' hinzufügen.

````
showShortcuts: true,
showLegend:true,
````
- - -

##Upgrade 3.1.0
- Erweiterung Bewertungen Ausgabe als Liste direkt in der Komponente
- Anpassung der default.htm ObjektBewertungen

````
    {% if liste == true %}<!-- neu -->
            <div id="btn-bewleft">
            <button class="btn-left btn-info" data-request-data="bewid: {{ bewid }}, bewoffset: {{ bewoffset }},bewmax: {{ bewmax }}" data-request="{{ __SELF__ }}::onBewLeft">{{ btnleft }}</button>
            </div>
        {% endif %}<!-- neu -->
                {% for bew in bewertungen %}
                    {% partial __SELF__ ~ "::item" bewertung = bew %}
                {% endfor %}
        {% if liste == true %}<!-- neu -->
            <div id="btn-bewright">
            <button class="btn-right btn-info" data-request-data="bewid: {{ bewid }}, bewoffset: {{ bewoffset }},bewmax: {{ bewmax }}" data-request="{{ __SELF__ }}::onBewRight">{{ btnright }}</button>
            </div>
        {% endif %}<!-- neu -->

````
- - -

##Upgrade 3.0.9
- Erweiterung Preisrechner um zwei Variablen.
````
 <div class="label">{{ pkautionlabel }}</div><div id="kaution">{{ kaution }}</div>
 <div class="label">{{ pohnekautionlabel }}</div><div id="ohnekaution">{{ ohnekaution }}</div>
````
Ausgabe der Kaution als Betrag und der Buchungssumme ohne Kaution

- Erweiterung PLatzhalter Ausgabe 'errechneter Preis' 

für [personen] Personen ,  jede weitere Person [weitere] pro Tag 
- - -

##Upgrade 3.0.8
- Anpassung Felder in Buchungsmaske`adresse.htm

```
<!-- Feld Telefon und Modil maxlength -->
<input type="text" name="tel" id="ctrl_tel" class="text frm_tel" maxlength="25" value="{{ data.tel }}"  placeholder="{{ labels.tel }}">
<input type="text" name="mobil" id="ctrl_mobil" class="text frm_mobil" maxlength="25" value="{{ data.mobil }}" placeholder="{{ labels.mobil }}">
```
- - -

##Upgrade 3.0.7
- Erweiterung der DB-Felder gast_tel (50) und gast_mobil (30)
- - -

##Upgrade 3.0.6
- Hausliste angepasst, keine Ausgabe wenn Objekte gleich 0
- Log-Verhalten geändert
- - -

##Upgrade 3.0.5
- Sprachen-Dateien angepasst und fehlende Texte des Backends eingefügt
- - -

##Upgrade 3.0.0 bis 3.0.4
- Interne Anpassungen
- - -

##Upgrade 2.9.9
- Update leaflet-marker
- - -

##Upgrade 2.9.8
- Update leaflet auf die neuste Version
- Anpassung der Maps in der Objektliste/default.htm {{ maptypeobj }} in {{ objekt.maptypeobj }}

````
var OpenStreetMap_DE = L.tileLayer('{{ objekt.maptypeobj }}', {
````
- - -

##Upgrade 2.9.7
- Update im Preisrechner default.htm 

````
 {% if script1 %}
        jQuery("#pbuchung").prop("disabled", false);
        jQuery("#panfrage").prop("disabled", false);
    {% endif %}
````

Dieses script unter  $(function() {  in der default.htm einfügen.
- - -

##Upgrade 2.9.6
- BUG in der Objektliste Interne-Nr
- - -

##Upgrade 2.9.5
- Keine Aktion erforderlich.
- - -

##Upgrade 2.9.4
- BUG im Preisrechner, aktivierung der Buttons
- - -

##Upgrade 2.9.3
- Update Preisrechner default.htm

````
<div id="btn"> <!-- neu -->
{% if showbuttons == 'all' %}
                <button id="pbuchung" class="btn btn-success btn-sm fewo-btnbuchung" disabled data-request-redirect="{{ purlbuchung }}/{{ alias }}" data-request="{{ __SELF__ }}::onBtnBuchung">{{ pbuchunglabel }}</button>
                <button id="panfrage" class="btn btn-primary btn-sm fewo-btnanfrage" disabled data-request-redirect="{{ purlanfrage }}/{{ alias }}" data-request="{{ __SELF__ }}::onBtnAnfrage">{{ panfragelabel }}</button>
                {% elseif showbuttons == 'buchung' %}
                <button id="pbuchung" class="btn btn-success btn-sm fewo-btnbuchung" disabled data-request-redirect="{{ purlbuchung }}/{{ alias }}" data-request="{{ __SELF__ }}::onBtnBuchung">{{ pbuchunglabel }}</button>
                {% elseif showbuttons == 'anfrage' %}
                <button id="panfrage" class="btn btn-primary btn-sm fewo-btnanfrage" disabled data-request-redirect="{{ purlanfrage }}/{{ alias }}" data-request="{{ __SELF__ }}::onBtnAnfrage">{{ panfragelabel }}</button>
                {% endif %}
</div> <!-- neu -->
````

Die mit neu gekennzeichneten Zeilen müssen eingefügt werden.

- Update Buchungsmaske default.htm

````
<div role="tabpanel" class="tab-pane" id="6">
    <div id="booking-end"></div>
    <div id="btnend"></div>
</div>
````

Tab-Pane mit der ID 6 muss jetzt so aussehen.
Die Buttons sind jetzt im Partial btnend.htm untergebracht.
- - -

##Upgrade 2.9.2
- Löschen von Bewertungen und Buchungen als SuperUser zulassen (Nur zum Zurücksetzen einer Seite)
- - -

##Upgrade 2.9.1
- Erweiterung Schema.org um Postionsdaten und Preise des Betriebes
- - - 

##Upgrade 2.9.0
- Anapssung der Bewertungsmaske. Erweiterung um Platzhalter im INPUT für verschiedene Sprachen.
{{plh.titel}},{{plh.anrede}},{{plh.message}},{{plh.vorname}},{{plh.name}},{{plh.ort}},{{plh.mail}}
- Anpassung der Suche bei Tage in Zeitraum, wenn im Fewo-Ferwalter unlogische Werte erfasst wurden.
- - -

##Upgrade 2.8.9
- Anpassung Belegungsplan Startmonat bei Suchanfrage nur den Offset geändert
- - -

##Upgrade 2.8.8
- Anpassung Suchmasken für verschiedenen Sprachen, Auswahl WerbeMail-Checkbox gefixt. 
- Neue Platzhalter für Suchmaske ( Anpassung nur bei mehrsprachigen Seiten)

````
<form name="searchmask" class="objektsuche form">
    {% if datecompact == 1 %}
            <div class="form-inputs">

                <input type="text" id="period" name="period" class="search-anreise"  autocomplete="off" placeholder="{{ labels.zeitraum }}" readonly/>
                <input id="anreise" name="anreise" class="search-anreise" autocomplete="off" type="hidden" readonly value="{{ anreise }}" />
                <input id="abreise" name="abreise" class="search-abreise" data-request="{{ __SELF__ }}::onDataChange" autocomplete="off" type="hidden" readonly value="{{ abreise }}" />
            </div>
    {% else %}
        <div class="form-inputs">
            <div class="label">{{ labels.anreise }}</div>
                <input id="anreise" name="anreise" class="search-anreise" autocomplete="off" type="text" placeholder="{{ labels.anreise }}" readonly value="{{ anreise }}" />
        </div>
        <div class="form-inputs">
            <div class="label">{{ labels.abreise }}</div>
                <input id="abreise" name="abreise" class="search-abreise" autocomplete="off" type="text" placeholder="{{ labels.abreise }}" readonly value="{{ abreise }}" />
        </div>
    {% endif %}
    {% if showtage == 1 %}
    <div class="form-days">
        <select id="tagein" name="tagein" class="search-days" data-width="auto" placeholder="Tage">
            {% for sday in countdays %}
            <option value="{{sday.id}}" {% if sday.selected %}{{ sday.selected }}{% endif %}>{{sday.name}}</option>
            {% endfor %}
        </select>
    </div>
    {% endif %}
    {% if ort ==1 %}
        <div class="form-ort">
                <select id="ort" name="ort" class="search-ort" data-width="auto" placeholder="Ort">
                    <option value="0">{{lblort}}</option>
                    {% for ort in orte %}
                        <option value="{{ort.id}}">{{ort.name}}</option>
                    {% endfor %}
                </select>
        </div>
    {% endif %}
    {% if land ==1 %}
        <div class="form-land">
            <select id="land" name="land" class="search-land" data-width="auto" placeholder="Land">
                <option value="0">{{lblland}}</option>
                {% for land in laender %}
                    <option value="{{land.id}}">{{land.name}}</option>
                {% endfor %}
            </select>
        </div>
    {% endif %}
    {% if region ==1 %}
        <div class="form-region">
            <select id="region" name="region" class="search-region" data-width="auto" placeholder="Region">
                <option value="0">{{lblregion}}</option>
                {% for region in regionen %}
                    <option value="{{region.id}}">{{region.name}}</option>
                {% endfor %}
            </select>
        </div>
    {% endif %}
    {% if objart ==1 %}
        <div class="form-objart">
                <select id="objart" name="objart" class="search-objart" data-width="auto" placeholder="Art">
                    <option value="0">{{lblobjart}}</option>
                    {% for objart in objarten %}
                        <option value="{{ objart.id }}">{{ objart.name }}</option>
                    {% endfor %}
                </select>
        </div>
    {% endif %}
    {% if objtyp ==1 %}
        <div class="form-objtyp">
                <select id="objtyp" name="objtyp" class="search-objtyp" data-width="auto" placeholder="Typ">
                    <option value="0">{{lblobjtyp}}</option>
                    {% for objtyp in objtypen %}
                        <option value="{{ objtyp.id }}">{{ objtyp.name }}</option>
                    {% endfor %}
                </select>
        </div>
    {% endif %}
    {% if zimmer == 1 %}
    <div class="form-rooms">
            <select id="zimmer" name="zimmer" class="search-rooms" data-width="auto" placeholder="Zimmer">
                <option value="0">{{lblzimmer}}</option>
                {% for i in 1..maxzimmer %}
                <option value="{{ i }}">{{ i }} {{lblzimmer}}</option>
                {% endfor %}
            </select>
    </div>
    {% endif %}
    {% if schlafzimmer == 1 %}
    <div class="form-schlafzimmer">
            <select id="schlafzimmer" name="schlafzimmer" class="search-schlafzimmer" data-width="auto" placeholder="Schlafzimmer">
                <option value="0">{{lblschlafzimmer}}</option>
                {% for i in 1..maxschlafzimmer %}
                <option value="{{ i }}">{{ i }} {{lblschlafzimmer}}</option>
                {% endfor %}
            </select>
    </div>
    {% endif %}
    {% if badezimmer == 1 %}
    <div class="form-badezimmer">
            <select id="badezimmer" name="badezimmer" class="search-badezimmer" data-width="auto" placeholder="Badezimer">
                <option value="0">{{lblbadezimmer}}</option>
                {% for i in 1..maxbadezimmer %}
                <option value="{{ i }}">{{ i }} {{lblbadezimmer}}</option>
                {% endfor %}
            </select>
    </div>
    {% endif %}
    {% if personen == 1 %}
        <div class="form-personen">
                <select id="personen" name="personen" class="search-personen" data-width="auto" placeholder="Personen">
                    <option value="0">{{lblpersonen}}</option>
                    {% for i in 1..maxpersonen %}
                    {% if i == 1 %}
                        <option value="{{ i }}">{{ i }} {{lblperson}}</option>
                    {% else %}
                        <option value="{{ i }}">{{ i }} {{lblpersonen}}</option>
                    {% endif %}
                    {% endfor %}
                </select>
        </div>
    {% endif %}
    {% if elemdrop %}
        <div class="checkies">
            {% for elemd in elemdrop %}
                {{ elemd|raw }}
            {% endfor %}
        </div>
        <div class="clearfix"></div>
    {% endif %}
    {% if elemcheck %}
        <div class="checkies">
            {% for elem in elemcheck %}
                {{ elem|raw }}
            {% endfor %}
        </div>
        <div class="clearfix"></div>
    {% endif %}

    <button type="submit" class="btn btn-success" data-request="{{ __SELF__ }}::onDataSearch" value="" id="searchbtn">{{ objektsuchesubmit }}</button>

</form>
````
- - -

##Upgrade 2.8.7
- Darstellung des Buchungskalender bei einer Tagsebuchung angepasst
- Fehler im Tab der Buchungsform behoben.
- - -

##Upgrade 2.8.6
- Fehler in der Berechnung des Tagesnamen in PHP ab 2020
- - -

##Upgrade 2.8.3
- Vorbereitung auf neue Image-Verwaltung außerhalb der October-System-Files
- - -

##Upgrade 2.7.8
- BUG in der Hausliste. Pagination wurde falsch berechnet.
- - -

##Upgrade 2.7.7
- BUG im Kalender, wenn eine Saisonzeit ohne Preis vorhanden ist. Diese konnte überbucht werden
- - -

##Upgrade 2.7.6
- Darstellung -Keine Preise- im Belegungsplan bei letzter Saison geändert. 
- - -

##Upgrade 2.7.5
- FIX Darstellungsfehler im Belegungskalender für das Jahr 2020. Betrifft nur den Belegungskalender
- - -

##Upgrade 2.7.4
- Erweiterung der Angebotsausgaben um den PLatzhalter [nt] = Tage bei Prozentangaben
- Erweiterung der Sprachmodule bei Bewertungen und Merkerlisten
- Optimierung der Ladezeiten bei Objektlisten und der Detailseite 
- - -

##Upgrade 2.7.3
- BUG in den Objektlisten Feld Beschreibung wenn Daten geändert wurden 
- - -

## Upgrade 2.6.7 bis 2.7.2
Kein Aktion nötig.
- - -

## Upgrade 2.6.6:
- Anpassung der CRON-Steuerung. Jetzt zusätzlich als URL ansteuerbar.
- Umstellung auf PHP 7.2 oder höher und MySQl 5.7
- - -

## Upgrade 2.6.5:
- Erweiterung Canonical für Mutli-Websites
- create_update20.php
- - -

## Upgrade 2.6.2 - 08.11.2019
- NEU Ausgabe von 2 Bildern in der Listenansicht (Bild 1 und Bild 2)

Objektliste default.htm Muss nur geändert werden wenn die Ausgabe gewünscht ist
````
<a href="{{ objekt.href }}"><img src="{{ objekt.image2.thumb(objekt.image_width,objekt.image_height, {mode:'crop'}) }}" alt="{{ objekt.image2.title }}" title="{{ objekt.image2.title }}"/></a>
````
- - -

## Upgrade 2.6.0 - 07.11.2019
- Anpassungen an PHP Version 7.3
- BUG nach Kalender-Update vom Hersteller behoben
- - -

## Upgrade 2.5.8 - 05.11.2019
- Umstellung der Tages- und Monatsnamen auf PHP(locale) je Sprache
- - -
## Upgrade 2.5.7 - 04.11.2019
- BUG im Buchungskalender, wenn mehrere Anreisetage übergeben wurden, behoben 
- - -

## Upgrade 2.5.6 - 04.11.2019
- Anpassung der Komponente schema.org
- Entfernen der 'itemprop'-Tags in den Objektlisten (Liste,Zufall,Treffer). Bei Änderung der Partials bitte anpassen. 
- - -

## Upgrade 2.5.5 - 29.10.2019
- BUG in Angebot-Detail wenn keine Angebote vorhanden Variable treffer
- - -

## Upgrade 2.5.4
- BUG in Bewertungen Pagination falsch
- - -

## Upgrade 2.5.3
- BUG in Saisonzeiten Anreisen am
- Neues Modul, Alle Bewertungen mit Pagination
- - -

## Upgrade 2.5.2
- Interne Optimierungen
- Prüfung auf Alias-Mailadressen bei Gästen (Airbnb, Booking)
- - -

## Upgrade 2.5.1
- Leistungen sortierbar aus Fewo-Verwalter. 
- - -

## Upgrade 2.5.0
- Angebot Zuschlag steuerbar. 
- - -

## Upgrade 2.4.0
- Änderung der Schema.org-Daten.
Erfassen sie die Koordinaten und Öffnungszeit ihres Betriebes in der Komponente Schema.org nach dem Update neu.
- - -

## Upgrade 2.3.0
- KFZ-Kennzeichen als Feld hinzugefügt
- - -

## Upgrade 2.2.9
- Interne Anpassung der Belegungsdaten. Schnelleres Laden der Belegungsdaten.
- - -

## Upgrade 2.2.8
- Abfrage bei Min-Preis ob Preis > 0€. Gibt keinen Min-Preis mit 0 € mehr aus.
- - -

## Upgrade 2.2.7
- Stornierungen und gebuchte Stornierungen werden nicht mehr in der Vorgangstabelle gespeichert.
- - -

## Upgrade 2.2.6
- Update der Objekteliste in den Angeboten

Anpassung der default.htm
````
<div id="fewo-objektliste" class="fewo-container {{ listcss }}">
    {{ items|raw}}
</div>
````

Neues Partial objlist.htm, war vorher in der default.htm
````
{{ pagination|raw }}
{% for objekt in objekte %}
<article class="post fewo-item {{ listitemcss }}">
    <div itemscope itemtype="http://schema.org/Product">
        {% if objekt.Titel %}
        <div class="fewo-titel"><a href="{{ objekt.href }}"><span itemprop="name">{{ objekt.Titel|raw }}</span></a></div>
        {% endif %}

        {% if objekt.slider == false %}
        <div class="fewo-image">
            <a href="{{ objekt.href }}"><img itemprop="image"  src="{{ objekt.image.thumb(objekt.image_width,objekt.image_height) }}" alt="{{ objekt.image.title }}" title="{{ objekt.image.title }}"/></a>
        </div>
        {% else %}
        <div class="fewo_list_image">
            <div class="fewo_listnavileft fewo_slidernav" onclick="javascript:bildZurueck('fewolistslider_{{ objekt.itemid }}_{{ objekt.id }}');"></div>
            <a href="{{ objekt.href }}"><img id="fewolistslider_{{ objekt.itemid }}_{{ objekt.id }}" data-posid="0" data-images='{{ objekt.images|raw}}' class="fewo_listimage" src="{{ objekt.img_bild}}" alt="{{ objekt.title }}" title="{{ objekt.title }}"/></a>
            <div class="fewo_listnaviright fewo_slidernav" onclick="javascript:bildWeiter('fewolistslider_{{ objekt.itemid}}_{{ objekt.id }}');"></div>
        </div>
        {% endif %}
        {% if objekt.Bewertung %}
        <div class="fewo-rating">
            {{ objekt.Bewertung|raw }}
            <div class="clearfix"></div>
            <div class="fewo-rating-text">{{ objekt.BewertungText|raw }}</div>
        </div>
        {% endif %}
        {% if objekt.Art %}<div class="fewo-art">{{ objekt.Art|raw }}</div>{% endif %}
        {% if objekt.Typ %}<div class="fewo-typ">{{ objekt.Typ|raw }}</div>{% endif %}
        {% if objekt.Region %}<div class="fewo-region">{{ objekt.Region|raw }}</div>{% endif %}
        {% if objekt.Sterne %}<div class="fewo-sterne">{{ objekt.Sterne|raw }}</div><div class="clearfix"></div>{% endif %}
        {% if objekt.Kurztext %}<div class="fewo-text">{{ objekt.Kurztext|raw }}</div>{% endif %}
        {% if objekt.ID %}<div class="fewo-number">{{ objekt.ID }}</div>{% endif %}
        {% if objekt.Zimmer %}<div class="fewo-room">{{ objekt.Zimmer|raw }}</div>{% endif %}
        {% if objekt.Schlafzimmer %}<div class="fewo-bed">{{ objekt.Schlafzimmer|raw }}</div>{% endif %}
        {% if objekt.Badezimmer %}<div class="fewo-bath">{{ objekt.Badezimmer|raw }}</div>{% endif %}
        {% if objekt.Groesse %}<div class="fewo-groesse">{{ objekt.Groesse|raw }}</div>{% endif %}
        {% if objekt.Betten %}<div class="fewo-betten">{{ objekt.Betten|raw }}</div>{% endif %}
        {% if objekt.Ausstattung %}<div class="fewo-ausstattung">{{ objekt.Ausstattung|raw }}</div>{% endif %}
        {% if objekt.LetzteBuchung %}<div class="fewo-letzte">{{ objekt.LetzteBuchung|raw }}</div>{% endif %}
        {% if objekt.Personen %}<div class="fewo-personen">{{ objekt.Personen|raw }}</div>{% endif %}
        {% if objekt.Erwachsene %}<div class="fewo-adults">{{ objekt.Erwachsene|raw }}</div>{% endif %}
        {% if objekt.Kinder %}<div class="fewo-childreen">{{ objekt.Kinder|raw }}</div>{% endif %}
        {% if objekt.KleinKinder %}<div class="fewo-childreen">{{ objekt.KleinKinder|raw }}</div>{% endif %}
        {% if objekt.OptBelegung %}<div class="fewo-optperson">{{ objekt.OptBelegung|raw }}</div>{% endif %}
        {% if objekt.Etage %}<div class="fewo-floor">{{ objekt.Etage|raw }}</div>{% endif %}
        {% if objekt.Adresse %}
        <div class="fewo-address">
            {{ objekt.Strasse|raw }}, {{ objekt.Land|raw }} {{ objekt.PLZ|raw }} {{ objekt.Ort|raw }}
        </div>
        {% endif %}
        {% if objekt.VerArt %}<div class="fewo-verart">{{ objekt.VerArt|raw }}</div>{% endif %}
        {% if objekt.btnDetail %}
        <div class="btn btn-success btn-sm fewo-btndetail"><a href="{{ objekt.href }}" {% if targetblank == 1 %}target="_blank"{% endif %}>{{ objekt.btnDetail }}</a></div>
        {% endif %}
        {% if objekt.btnBuchung %}
        <div class="btn btn-success btn-sm fewo-btndetail"><a href="#" data-request="{{ __SELF__ }}::onBtnBuchen" data-request-data="offerid:{{ offerid }},objectid: {{ objekt.id }}">{{ objekt.btnBuchung }}</a></div>
        {% endif %}
        {% if objekt.btnAngebot %}
        <input type="hidden" name="offerid{{ id }}" value="{{ id }}">
        <div class="btn btn-success btn-sm fewo-btndetail"><a href="#" data-request="{{ __SELF__ }}::onBtnAngebot" data-request-data="offerid:{{ offerid }},objectid: {{ objekt.id }}">{{ objekt.btnAngebot }}</a></div>
        {% endif %}
    </div>
</article>
{% endfor %}
{{ pagination|raw }}
````
- - -

## Upgrade 2.2.5
 - Bug in Datumsfeld bei Mitreisenden gefixt.
 - Erweiterung der Panoramabilder um den Bootstrap-Slider
- - - 

## Upgrade 2.2.4
- Bug in menuetab.htm in Buchungsmaske. Tab 7 wurde nicht disabled.
Anpassung image/default.htm

````
{% if noimage == 0 %}
    {% if imagetype == 5 %}
        <header>
        <div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="6000">
            <ol class="carousel-indicators">
                {% for image in images %}
                    <li data-target="#carouselIndicators" data-slide-to="{{ image.id }}" class="{{ image.active }}"></li>
                {% endfor %}
            </ol>
            <div class="carousel-inner" role="listbox">
                {% for image in images %}
                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item {{ image.active }}" style="background-image: url('{{ image.image }}')">
                    {% if showtitle %}<h2 class="display-4">{{ image.title }}</h2>{% endif %}
                    {% if showdesc %}<p class="lead">{{ image.description|raw }}</p>{% endif %}
                </div>

                {% endfor %}
            </div>
            <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ prev }}</span>
            </a>
            <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">{{ next }}</span>
            </a>
        </div>
        </header>
    {% else %}
        <div class="{{ imgcss }} fewo-image-{{ type }} {{ type }}">
        {% if imagecrop %}
            <img src="{{ image.thumb( img_width, img_height,{mode:'crop'}) }}" alt="{{ image.title }}" title="{{ image.title }}">
        {% else %}
            {% if type == 'panorama' %}
                <img src="{{ image.thumb(auto,auto) }}" alt="{{image.title}}">
            {% else %}
            <img src="{{ image.thumb( img_width, img_height) }}" alt="{{ image.title }}" title="{{ image.title }}">
            {% endif %}
        {% endif %}
        </div>
    {% endif %}
{% endif %}
`````
- - -

## Upgrade 2.2.2
Anpassung des Partials Mitreisende (mitreisende.htm) in der Buchungsmaske
Values der Felder geändert und Val  Geburtstagsfeld im jQuery-Teil

````
<div class="mit_header">
    <div class="mitreisende_vorname is-required">{{ labels.vorname }}</div>
    <div class="mitreisende_nachname is-required">{{ labels.name }}</div>
    {% if showmitreisendegeb %}
    <div class="mitreisende_gebdatum is-required">{{ labels.geb }}</div>
    {% endif %}
    </div>
    {% for mitreisender in mitreisende %}
    <div class="mitreisender">
        <input type="text" name="mitvorname[]" id="ctrl_mitvorname_{{ mitreisender.id }}" class="text form-control frm_mitreisende" value="{{ mitreisender.mitvorname }}">
        <span id="error-vorname" class="validate"></span>
        <input type="text" name="mitname[]" id="ctrl_mitname_{{ mitreisender.id }}" class="text form-control frm_mitreisende" value="{{ mitreisender.mitname }}">
        {% if showmitreisendegeb %}
            <input type="text" name="mitgeb[]" class="text form-control frm_gebdatum" id="ctrl_mitgeb_{{ mitreisender.id }}" value="{{ mitreisender.mitgeb }}">
        {% endif %}
    </div>
    {% endfor %}
<span id="error-mitreisende" class="validate"></span>
        {% if showmitreisendegeb %}
        <script type="text/javascript">
            jQuery(document).ready(function() {
                {% for mitreisender in mitreisende %}
                jQuery('#ctrl_mitgeb_{{ mitreisender.id }}').dateEntry({dateFormat: 'dmy.',spinnerImage: ''});
                jQuery('#ctrl_mitgeb_{{ mitreisender.id }}' ).val({{ mitreisender.mitgeb }});<!--- NEU --->
                {% endfor %}
            }); 
        </script>
        {% endif %}
</div>
````
- - -

## Upgrade 2.2.1
- Anpassung Werbemail bei HOBEX-Zahlungen und Übergabe an Fewo-Verwalter.
- - -

## Upgrade 2.2.0
- Rundungsfehler bei Bewertungen in der Listenseite gefixt.
- - -

## Upgrade 2.1.9
- Neuer Platzhalter in Mail-Templates für Buchungen. {{ LANDLANG }} = Land/Region ausgeschrieben.
- - -

## Upgrade 2.1.8
- Umstellung der Upgrade Sprache auf deutsch (Eine Bitte vieler Kunden).
- Checkbox für Werbemails (z.B. Bewertungserinnerung) in der Buchungsmaske hinzugefügt. 
- Kundenbefragung per E-Mail nur bedingt zulässig! BGH Urteil IV ZR 225/17

Partial buchungsmaske/zusammen.htm muss angepasst werden. Bitte folgenden Code nach sonstigesCheck einfügen.
```
{% if werbemail %}
        <input type="checkbox" name="werbemail">
        <div class="label data">{{ werbemail|raw }}</div>
{% endif %}
````
Mit der aktuellen Version vom Fewo-Verwalter werden diese Daten im Fewo-Verwalter gespeichert.
Das Senden der eMails erfolgt dann nur noch bei Gästen die zugestimmt haben.
- Fehler beim abholen der Vorgänge bezogen auf Zahlungen beseitigt.
- - -

## Upgrade 2.1.7
- FIX BUG in price calculator. In the Partials and Views are no changes.
- - -

## Upgrade 2.1.6
- PHP code has been changed. In the Partials and Views are no changes.
- - -

## Upgrade 2.1.5
- There is nothing to do
- - -

## Upgrade 2.1.4
- There is nothing to do
- - -

## Upgrade 2.1.3
- Add blocking dates

    Insert blocked time range in Fewo-Verwalter Settings 
    
- Change booking infos and postpages in booking-component
    
    complete text-fields in the component
    
    Change default.htm in bookingmask. delete line 'infotext.zusammenfassung'
    
    Add line {% if zusammenfassung %}{{ zusammenfassung|raw }}{% endif %} in zusammenfassung.htm
````
<div id="error-check"></div>
<div class="zusammenfassung">
    {% if zusammenfassung %}{{ zusammenfassung|raw }}{% endif %}
    <div class="daten">
````
- Add info-text field for 'booking inquiry' in booking control.    
- - -

## Upgrade 2.0.1
- Insert button 'more objects' in component objectbuttons
Change only your customized partial objektbuttons/default.htm
```
 {% if btn_weitere == true %}
     <button class="btn btn-success btn-sm fewo-btnweitere" data-request-redirect="{{ urlweitere }}/{{ hausalias }}" data-request="{{ __SELF__ }}::onBtnWeitere">{{ weiterelabel }}</button>
 {% endif %}
```
- - -

## Upgrade 2.0.0
- Insert house list and house detail components
On the house detail-site you can under haouse-detail component one object-list component.
this component show any objects in this house. 
- - -

## Upgrade 1.9.4
- Change HOBEX Request to automatic route
- Change listfilter field daysIn
- - -

#### Have you edit the default partials, you must change your partiels under CMS->Partials
listfilter/default.htm -> Replace from  {% if showtage  %} to {% endif %}
Also delete the funcktion filterTage(Tage) and all references to this function and complete the componenten-labels (Days in)

````
{% if showtage %}
    <div class="form-inputs">
        <div class="label">{{ labels.tagein }}</div>
        <select id="tagein" name="tagein" class="search-tagein" data-request="{{ __SELF__ }}::onDataChange" placeholder="{{ labels.tagein }}" >
            {% for sday in countdays %}
                <option value="{{sday.id}}" {% if sday.selected %}{{ sday.selected }}{% endif %}>{{sday.name}}</option>
            {% endfor %}
        </select>
    </div>
{% endif %}
````

Booking paid (Buchung abgeschlossen) / URL booking-paid/:id
````
<!-- container -->
<section class="jumbotron">
    <div class="container">     
        {% component 'Paid' %}
        {% if Paid.Error  %}
            {% content 'Zahlungsabbruch' %}
            {{ Paid.Message|raw }}
        {% else %}
            {% content 'Zahlungsabschluss' %}
            {{ Paid.Message|raw }}
        {% endif %}
       
    </div> 
</section>
````
- - -

## Upgrade 1.9.3
- Remove tooltip in services,
Tooltip and popper doesn't work on mobile devices
- change objekttextsearch

Change partial objekttextsearch/default.htm
````
<div class="textsuche">
    <div class="ui category search">
            <input class="prompt" type="text" placeholder="{{ placeholder }}">
            <i class="search icon blue"></i>
        <div class="results"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var search = $(".ui.search").search({
            // Set source property to get categories data.
            source: {{ searchOptions|raw }},
            type: "category",
            duration: 100,
            maxResults: 15,
            showNoResults: true,
        });
    });
</script>
````
- - -

## Upgrade 1.9.1
- Change function getBokkings from FewoVerwalter
- - -

## Upgrade 1.9.0
- If needed, ddd sum 'mindaysprice' in objectlist and object base data

Change Partial stammdaten/saisonzeit.htm, add in thead and tbody
````
 {% if mintagepreis == 1 %}
    <td class="fewo-head-mintagepreis">{{ saisonlabels.mintagepreis|raw }}</td>
 {% endif %}
 
  {% if mintagepreis == 1 %}
    <td class="fewo-saison-preis">{{ saison.mintagepreis|raw }}</td>
 {% endif %}
````
Add label settings in object list with parameter [mintagepreis] and [mintage]
- - -

## Upgrade 1.8.6
- Insert Hobex results in event-log 
- Change voting-slider partiels.

ObjektBewertungen/item.htm
````
<div id="bew-item" class="bew-item">
    <div class="bew_titel"><h2>{{ bewertung.titel|raw }}</h2></div>
    <select id="rating_{{ bewertung.id }}">
        <option value=""></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    {{ bewertung.script|raw }}
    <div class="bew-text">{{ bewertung.ratingtext }}</div>

    <div class="bew_objtitel"><a href="{{ bewertung.objhref }}" {% if bewertung.targetblank %}target="_blank" {% endif %}>{{ bewertung.objtitel|raw}}</a></div>
    {% if showimage %}
    <div class="bew_image">
        <a href="{{ bewertung.objhref }}" {% if bewertung.targetblank %}target="_blank" {% endif %}><img src="{{ bewertung.image.thumb( img_width, img_height) }}" alt="{{ bewertung.image.title }}" title="{{ bewertung.image.title }}"></a></div>
    {% endif %}
    <div class="bew_nachricht">{{ bewertung.nachricht|raw }}</div>
    <div class="bew_datum">{{ bewertung.date }}</div>
    <div class="bew_gastname">{{ bewertung.author|raw }}</div>
    {% if bewertung.catschow == 1 %}
    <div class="{{ csscat }} fewo-cat">
        {% set i=0 %}
        {% for key, category in bewertung.categories %}
        {% set i = i +1 %}
        <div class="cat-name category{{ i }}">{{ key }}<span class="cat-number">({{category }})</span></div>
        {% endfor %}
    </div>
    {% endif %}
</div>

````
- - -

## Upgrade 1.8.5
- Fix HOBEX login
- Please insert error text in bookingmask-modul
- - -

## Upgrade 1.8.4
The following elements only have to be adjusted,
if partials of the components have been changed under Partials
- - -

## Only if you want to use Semantic UI
- Component 'Text Suchfeld',  Change ObjektTextfeldsuche/default.htm
````
{% if semantic %}
<div class="ui category search">
    <div class="ui icon input">
        <input class="prompt" type="text" placeholder="{{placeholder}}">
        <i class="search icon"></i>
    </div>
    <div class="results"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ui.search')
            .search({
                type: 'category',
                source:  {{opts|raw}},
                error: {noResults:'{{noresults|raw}}'},
            });
    });
</script>
{% else %}
<div class="textsuche">
    <select id="objekttextsearch" name="objettextsearch" style="width:300px;">
        {% for key, obj in optionsearch %}
        <option value="{{ key }}">{{ obj|raw }}</option>
        {% endfor %}
    </select>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#objekttextsearch').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
        $("#objekttextsearch").select2({

        });
    });
</script>
{% endif %}
````
- - -

## Upgrade 1.8.3
- Change script in partials when used datecompact is selected
####in objektsuche/default.htm, after showtage  inset part datecompact
`````
 {% if showtage %}
    $('#tagein').append($('<option>', {
            value: 0,
            text: '{{ labels.tagein }}'
        }));
{% endif %}
{% if datecompact == 1 %}
    $('#period').attr("placeholder", '{{dateplaceholder}}');
{% endif %}
`````
####in listfiler/default.htm, before picker.bind('datepicker-change')
`````
{% if datecompact == 1 %}
    $('#period').attr("placeholder", '{{dateplaceholder}}');
{% endif %}
`````
