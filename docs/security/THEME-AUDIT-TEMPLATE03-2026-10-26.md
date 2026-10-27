# Sicherheitsprüfung Theme Template 03

Stand: 26.10.2026. Geprüft: `D:\Entwicklung\fewoverwalter\themes\fewo`, Theme-Code `fewo3`, „Fewo-Verwalter Premium Template“.

## Ergebnis

**Das Theme enthält zusätzliche sicherheitsrelevante Ausgabefehler.** Besonders wichtig sind ungefilterte Objekttitel, Bildtexte in HTML-Attributen, Kartenkoordinaten als JavaScript und die eingebundene Objektsuche. Die vorherigen Plugin-Korrekturen beseitigen diese Stellen nicht vollständig. Das Theme lädt außerdem eigene verwundbare Bibliotheksversionen.

Die Befunde sind unten separat mit `THEME-01` bis `THEME-08` erfasst: sechs prioritäre Befundgruppen, ein bedingter Tooltip-Befund und ein ungeklärter Kontaktformular-Prüfpunkt. P1/P2 bezeichnen Bearbeitungsprioritäten, keine CVSS-Werte. Kein zusätzlicher P0-Befund und kein Hinweis auf eine bereits erfolgte Kompromittierung wurden nachgewiesen.

**Voraussetzung der bestätigten Injektionspfade:** Kontrolle über importierte oder redaktionell gepflegte Objekt-, Bild- oder sonstige Stammdaten. Ein anonymer Angreifer kann diese Felder nicht nachweislich allein durch Aufrufen einer URL verändern. Manipulierte Inhalte können aber nach ihrer Speicherung im Browser anderer Besucher aktiv werden. Je nach Sitzung sind dann etwa manipulierte Buchungsansichten, Abgriff eingegebener Daten oder Aktionen im Kontext des Besuchers möglich. Konkrete Auswirkungen hängen von erreichbarer Seite, Sitzung und effektivem Browser-/Serverschutz ab.

## Umfang und Grenzen

- Alle **375 Dateien** des Themeordners inventarisiert und mit SHA-256 erfasst.
- **289 Textdateien mit 65.060 Zeilen** musterbasierend gescannt, einschließlich Bibliotheken, Styles und Source Maps. Darunter **102 HTM-Dateien und 23 JavaScript-Dateien**. Die übrigen Dateien sind hauptsächlich Bilder und Fonts.
- Keine separaten PHP-Dateien, keine PHP-Tags und keine nichtleeren eingebetteten CMS-PHP-Codeabschnitte gefunden. Deshalb kein eigener direkter SQL-/Dateizugriffs-Endpunkt im Theme nachgewiesen. Registrierte Plugin-Komponenten führen weiterhin PHP aus.
- Manuell vertieft: Layout und globale Assets, Objekt-/Angebotslisten, Karten, Slider/Galerien, Buchungsfelder, Eigentümerseite, Bewertungseinbindung, Kontaktformular, Fehler- und Abschlussseiten sowie die benötigten Plugin-Datenquellen.
- Der Vollscan ist keine manuelle Zeile-für-Zeile-Prüfung aller 65.060 Zeilen oder ein vollständiges Audit der Fremdbibliotheken. Live-Domain, kundenspezifische Backend-Konfiguration, Webserverheader und Datenbankinhalte wurden nicht aufgerufen.
- Theme und Anwendungscode wurden bei dieser Folgeprüfung **nicht verändert**. Neue Dateien sind Bericht, Inventar, Scanmetadaten und isolierte Nachweise im Pluginordner `docs/security`.

## Priorisierte Befunde

| ID | Priorität | Befund | Nachweis und Reichweite |
|---|---|---|---|
| THEME-01 | P1 | Ungefilterte Objekttitel und Inhalte erlauben gespeichertes XSS | Tatsächliche Listen-Vorlage gerendert; HTML- und Attributausbruch bestätigt. Listen sind eingebunden. |
| THEME-02 | P1 | Bildtitel brechen aus dem JSON-Datenattribut aus | Rendering plus HTML-Parser bestätigt; Bildslider auf Familienurlaubsseite aktiviert. |
| THEME-03 | P1 | Slider-Bildtitel ungefiltert in `alt` und `data-caption` | Tatsächliche Slider-Vorlage mit Bild-/Thumbnailmodus gerendert; Attributausbruch bestätigt. Modusabhängig. |
| THEME-04 | P1 | Kartenkoordinaten aus Textfeldern werden als JavaScript eingesetzt | Import-/Schema-/Ausgabekette verfolgt; Ausdruck bleibt im gerenderten JavaScript erhalten. |
| THEME-05 | P1 | Globale Objektsuche erzeugt HTML aus ungefilterten Titeln | Tatsächliche JavaScript-Suchvorlage isoliert ausgeführt; Plugin-/Theme-Grenze betroffen. |
| THEME-06 | P1 | Aktiv eingebundene jQuery 1.12.0 und Bootstrap 4.0.0 | Versionsheader, Layout-Einbindung und Hersteller-Advisories. Konkreter CVE-Angriff nicht live getestet. |
| THEME-07 | P2, bedingt | Leistungs-Tooltip mit ungefiltertem Attributinhalt | Bei gesetztem `showToolTip` reproduziert; Schreibweise unterscheidet sich vom Pluginflag `showTooltip`. |
| THEME-08 | Prüfpunkt | Kontaktformular deaktiviert Datenbereinigung | Konfiguration bestätigt; zugehörige Komponente fehlt im lokalen Pluginbestand. Kein eigenständiger XSS-/CSRF-Nachweis. |

## THEME-01 Ungefilterte Objektdaten

**Belege im Theme:**

- `partials/objektliste_gesamt/default.htm:27,30,52,54`: `objekt.Titel|raw` sowohl im `title`-Attribut als auch im sichtbaren HTML.
- `partials/ObjektlisteLage/default.htm:51`: Titel mit `raw`.
- `partials/AngebotDetail/objlist.htm:19` und weitere Textausgaben: Objektinformationen mit `raw`.
- `partials/objektdetail/angebote.htm:10–11`: Angebotstitel/Untertitel mit `raw`.
- `pages/detailseite.htm:610`: Beschreibung mit `raw`; dort kann formatiertes HTML fachlich gewünscht sein und muss anders behandelt werden als ein Titel.

**Datenweg:** `classes/Api.php:2448` übernimmt den übersetzten Objekttitel als Zeichenkette; `components/objektliste.php:1716` reicht ihn als `Titel` weiter. Die Hilfsfunktion `checkText` ist ebenfalls kein HTML-Sanitizer: der Tagfilter ist auskommentiert (`classes/Api.php:3326` ff.).

**Nachweis:** Trotz aktiviertem Twig-Autoescaping wurde ein harmloses Testelement im Titel als echtes HTML gerendert. Ein Anführungszeichen im Titel erzeugte zusätzlich ein neues HTML-Attribut am Link. Derselbe Ausgabekanal erlaubt prinzipiell auch aktive HTML-/Eventhandler-Inhalte.

**Maßnahme:** Titel, Orts-/Adressfelder und andere reine Texte kontextgerecht escapen, insbesondere innerhalb von Attributen. Gewünschte formatierte Beschreibungen separat mit einer festgelegten HTML-Positivliste bereinigen. Nicht pauschal sämtliche `raw`-Filter entfernen: serverseitig erzeugte Pagination, Komponentenmarkup und Formatierungen sind gesondert zu behandeln. Andere gleichartige Kopien im Plugin ebenfalls erfassen.

## THEME-02 Bilddaten im JSON-Attribut

**Belege:** `partials/objektliste_gesamt/default.htm:52` und `partials/ObjektlisteLage/default.htm:35` setzen `objekt.images|raw` in ein einfach zitiertes `data-images`-Attribut.

`components/objektliste.php:1993–2004` übernimmt `imglang_titel` aus den Bilddaten und erzeugt `stripcslashes(json_encode($ff))`. JSON schützt den umgebenden HTML-Attributkontext nicht. Zusätzlich kann `stripcslashes` notwendige JSON-Escapes wieder entfernen. Bildtitel werden unter anderem durch `classes/Api.php:1085` importiert.

**Nachweis:** Ein Bildtitel mit einem Apostroph erzeugte im HTML-Parser ein zusätzliches Attribut am Bild. Das ist keine rein theoretische Variante: `pages/listenseiten/listenseite-familienurlaub.htm:48` aktiviert `imagesettings[slider] = "slider"`.

**Maßnahme:** JSON korrekt serialisieren und als HTML-Attribut escapen; `stripcslashes` aus der JSON-Erzeugung entfernen. Alternativ Daten in einem sauber kodierten JSON-Block ablegen. Tests für Apostrophe, Anführungszeichen, Backslashes und HTML ergänzen. Theme und Plugin-Datenaufbereitung müssen gemeinsam angepasst werden.

## THEME-03 Sliderattribute

**Belege:** `partials/slider/default.htm:135,139,162,166` enthält ungefilterte `data-caption`-Werte, `:163,201` ungefilterte Bildtitel im `alt`-Attribut.

`components/Slider.php:164` übernimmt übersetzte Bildtitel; `:258` übernimmt redaktionelle Slidertitel. Die Detailseite registriert die Slider-Komponente (`pages/detailseite.htm:81`). Fancybox ist dort aktuell deaktiviert; die `alt`-Ausgaben im Bild-/Thumbnailmodus benötigen Fancybox jedoch nicht. Die konkrete Sliderkonfiguration aus der Datenbank wurde nicht geladen.

**Nachweis:** Im isoliert gerenderten Bild-/Thumbnailmodus erzeugte ein Titel ein zusätzliches Attribut am Bild.

**Maßnahme:** `raw` aus Textattributen entfernen; Beschriftungen, die eine Galerie später als HTML interpretiert, zusätzlich an dieser DOM-Senke absichern. Alle Sliderdarstellungen einschließlich Thumbnails prüfen.

## THEME-04 JavaScript in Kartendaten

**Belege:**

- `partials/ObjektlisteLage/objgesmap.htm:14,38`: Koordinaten direkt in `L.latLng(...)`.
- `partials/maps/default.htm:15–19`: Koordinaten direkt in JavaScript-Zuweisungen.
- `classes/Api.php:2238–2239`: LAT/LNG werden als Zeichenketten übernommen.
- `updates/update72.php:38–39`: Koordinatenspalten sind Strings, keine numerischen Datentypen.
- `components/objektliste.php:1628–1629`: Werte unverändert in Kartendaten.

**Nachweis:** Ein Testkoordinatenwert mit einem harmlosen JavaScript-Ausdruck wurde unverändert als ausführbarer Ausdruck in `L.latLng(...)` ausgegeben. Er benötigt keine HTML-Sonderzeichen, weshalb normales HTML-Escaping allein nicht schützt. Das Testskript hat den Ausdruck nicht im Browser ausgeführt. `pages/listenseiten/kartensuche.htm:17,22` aktiviert die betreffende Leaflet-Ausgabe; der Pluginadapter wandelt `mapOption = 0` in das boolesche Themeflag um.

**Maßnahme:** Koordinaten vor Speicherung und Ausgabe strikt numerisch und auf gültige Bereiche prüfen (Breite −90 bis 90, Länge −180 bis 180). Nur echte Zahlen serialisieren; ungültige Datensätze ablehnen oder ohne Marker behandeln. Zusätzlich `marker.box` in `objgesmap.htm:32` als JavaScript-String korrekt serialisieren, statt gerendertes HTML in einfache Anführungszeichen einzusetzen. Letzteres ist eine weitere Kontextschwäche; dafür wurde hier keine separate vollständige Angriffskette behauptet.

## THEME-05 Objektsuche im globalen Header

**Belege:** `partials/site/header.htm:18,67` registriert/rendert `ObjektTextfeldsuche`; `partials/ObjektTextfeldsuche/default.htm:12` übergibt `searchOptions` an das Suchwidget.

Der Pluginteil `components/objekttextsearch.php:163–175` erzeugt Suchdaten mit den ursprünglichen Objekttiteln. Die tatsächlich eingebundene Suchbibliothek `assets/js/search.js:1427–1428` hängt den Titel ohne Escaping an HTML an; `:904–913` setzt Ergebnis-HTML in den DOM ein. Gleichartige direkte Ausgaben existieren für Kategorien und weitere Felder.

**Nachweis:** Die echte `category`-Vorlagenfunktion aus `search.js` wurde in einem isolierten JavaScript-Kontext mit Testdaten ausgeführt. Sie gab den Testtitel als HTML-Element zurück. Es wurde kein Browsercode ausgeführt. Das JSON-Encoding der Übergabedaten verhindert diesen späteren DOM-XSS-Pfad nicht.

**Maßnahme:** Ergebnisfelder als Text ausgeben beziehungsweise vor Einbau in HTML korrekt escapen; Ziel-URLs separat prüfen. Das benötigt eine Plugin-/Suchwidgetkorrektur zusätzlich zur Themeprüfung und ist nicht allein durch Entfernen von `raw` am gesamten JSON lösbar.

## THEME-06 Alte Bibliotheken werden tatsächlich geladen

`partials/site/header.htm:49–50` bindet bei jeder Seite des Standardlayouts direkt ein:

| Datei | Lokale Version | Herstellerbeleg |
|---|---|---|
| `assets/javascript/jquery.min.js:1` | jQuery 1.12.0 | [CVE-2020-11022 beim jQuery-Projekt](https://github.com/jquery/jquery/security/advisories/GHSA-gxr4-xjj5-5px2): unsichere HTML-Verarbeitung, korrigiert ab 3.5.0. |
| `assets/bootstrap/js/bootstrap.min.js:2` | Bootstrap 4.0.0 | [Bootstrap-Sicherheitsrelease](https://blog.getbootstrap.com/2019/02/13/bootstrap-4-3-1-and-3-4-1/): CVE-2019-8331 in Tooltip-/Popover-Templates, korrigiert mit 4.3.1 beziehungsweise 3.4.1. |

Diese Fixversionen bezeichnen historische Grenzen der genannten Advisories, keine Empfehlung, jetzt auf genau diese ebenfalls alten Versionen zu wechseln. Eine gepflegte Zielversion ist mit den verwendeten October-, Kalender-, Galerie- und Suchplugins abzustimmen.

Zusätzlich vorhanden: `assets/vendor/jquery.js` 1.11.1 und `assets/vendor/bootstrap.js` sowie dessen Einzelmodule 3.3.7. Für diese zusätzlichen Kopien wurde keine aktive Einbindung im geprüften Standardlayout gefunden. Vor Entfernen kundenspezifische Referenzen prüfen.

**Maßnahme:** Aktive Themebibliotheken unabhängig von den Pluginkopien aktualisieren, UI-Kompatibilität testen, ungenutzte Altdateien nach Referenzprüfung entfernen und einen Versions-/Advisory-Check etablieren. Versionsmatch und Einbindung sind bestätigt; sie allein beweisen noch keinen live ausnutzbaren CVE-Pfad.

## THEME-07 Bedingter Tooltipfehler

`partials/Buchungsmaske/leistungen.htm:25` setzt `leist.tooltip|raw` in `title`. Die Quelle ist die Leistungsbeschreibung (`classes/Booking.php:980`). Mit gesetztem `showToolTip` wurde der Attributausbruch isoliert nachgewiesen.

**Wichtige Einschränkung:** Das Template fragt `showToolTip` ab, während der aktuelle Buchungsmaskencode `showTooltip` liefert (`components/buchungsmaske.php:622,1573`). Deshalb ist die gefährliche Ausgabe über diesen regulären Flagpfad derzeit nicht als aktiv bestätigt. Eine bloße Korrektur der Schreibweise könnte sie aktivieren.

**Maßnahme:** Attributescapierung gleichzeitig mit der Flagbereinigung korrigieren und sowohl aktivierte als auch deaktivierte Leistungsinfos testen. Nicht als weiteren sicher anonym erreichbaren Angriff zählen.

## THEME-08 Kontaktformular separat verifizieren

`pages/service/kontakt.htm:7–16` verwendet `genericForm` mit `sanitize_data = "disabled"`; die lokale Plugininstallation enthält keine passende Komponente. Damit lässt sich die serverseitige Validierung, Speicherung, Mailausgabe und Missbrauchsbegrenzung hier nicht belastbar prüfen.

`partials/genericForm/default.htm:3` enthält ausdrücklich `form_token()`, und `:30` bindet eine reCAPTCHA-Teilvorlage ein. Deren Anwesenheit beweist weder eine funktionierende Prüfung noch deren Fehlen. Auch HTML-`required` ersetzt keine serverseitigen Regeln.

**Maßnahme:** In der tatsächlichen Kundeninstallation Formularplugin und Version identifizieren; serverseitige Validierung, sichere Ausgabe, CSRF, CAPTCHA und Rate Limits prüfen. Die abgeschaltete Bereinigung ist ein Prüfhinweis, kein für sich allein bewiesener XSS-Fehler.

## Abgleich mit den Pluginmaßnahmen

- Die Theme-Bewertungsüberschreibung `partials/ObjektBewertungen/default.htm:9` delegiert den einzelnen Bewertungseintrag an die dynamische Komponenten-Teilvorlage. Im Theme existiert keine eigene `item.htm`/`item-svg.htm` dafür. Die zuletzt reparierten Bewertungs-Textausgaben werden somit nach dem vorliegenden Quellstand nicht durch eine alte Theme-Kopie ersetzt; im CMS-Abnahmetest noch prüfen.
- Die Eigentümerseite konfiguriert eine Session-Sperre und Eigentümergruppe (`pages/service/eigentuemerdaten.htm:37–40`). Sie ist nicht allein deshalb öffentlich, weil `is_hidden = 0` gesetzt ist. Die notwendige serverseitige Handlerprüfung bleibt Aufgabe des Plugins.
- Die Buchungsadressvorlage gibt gewöhnliche Gastfelder ohne `raw` aus. Die Kontrollprobe für ein Gast-Titelfeld blieb korrekt escaped. Keine pauschale Behauptung, alle Formulare seien XSS-anfällig.
- Die Fehlerseite `pages/500.htm` gibt einen generischen Text aus und keinen Stacktrace. Effektiver Debugmodus und Serverheader sind hiervon unabhängig.
- Für Rückmeldeseiten, Downloadfreigaben und Zahlungsbestätigungen gelten weiterhin die offenen Plugin-/Betriebspunkte aus [MASSNAHMEN.md](MASSNAHMEN.md).

## Nachweise und nächste Arbeiten

[Dateiinventar mit Hashes](theme-inventory-2026-10-26.json), [Vollscan-Metadaten](theme-scan-2026-10-26.json), [Twig-/HTML-Proben](verify-theme-isolated.php), [Suchwidget-Probe](verify-theme-search.cjs) und [Prüfprotokoll](theme-verification-2026-10-26.txt).

Die PHP-Proben nutzen die tatsächlich vorhandenen Twig-Bibliotheken mit aktiviertem HTML-Autoescaping, entfernen nur CMS-Metadaten/Asset-Registrierungsblöcke und rendern die echten betroffenen Teilvorlagen. Ergebnis: sechs reproduzierte unsichere Ausgabefälle sowie eine sichere Kontrollprobe. Die zusätzliche JavaScript-Probe bestätigt die HTML-Ausgabe der echten Suchvorlagenfunktion. Diese Nachweise prüfen Ausgabesenken; sie simulieren weder einen vollständigen unauthentifizierten Angriff noch einen Kundenbrowser.

Empfohlene Reihenfolge:

1. THEME-01 bis THEME-05 zusammen mit den jeweils betroffenen Plugin-Datenquellen korrigieren; anschließend die Nachweisproben in Sicherheitstests mit umgekehrter Erwartung überführen.
2. Die aktiven Themebibliotheken aktualisieren und Listen, Karten, Suche, Slider, Buchung und Eigentümerbereich gemeinsam testen.
3. Tooltipflag sicher korrigieren und Kontaktformular auf der realen Installation abnehmen.
4. Keine pauschale Ersetzung sämtlicher `raw`-Filter; formatierte Inhalte und reines Textmarkup getrennt behandeln. Vor Veröffentlichung mit zwei Eigentümern, anonymem Besucher und redaktionell importierten Sonderzeichen testen.

Alle Themebefunde sind **offen**; diese Prüfung hat keine Theme-Korrekturen ausgerollt.
