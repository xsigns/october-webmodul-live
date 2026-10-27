# Sicherheitsprüfung October-Webmodul

Stand: 26.10.2026 · Plugin `xsigns/fewo` · Git `7d531528b8bf00e742e86a9a9478ae66594f9066` · letzte Migration `3.10.50`.

**Historischer Ausgangsbefund:** Dieser Bericht beschreibt den Stand vor den Korrekturen. Den aktuellen Bearbeitungsstand, die Tests und Rollout-Voraussetzungen enthält [MASSNAHMEN.md](MASSNAHMEN.md). Die Zeilenangaben beziehen sich auf den oben genannten Ausgangscommit.

## Ergebnis und Entscheidung

**Es bestehen mehrere unmittelbar zu behebende Sicherheitsfehler im Anwendungscode.** Am dringendsten sind beliebige Dateidownloads, SQL-Injection, unzureichende Zahlungszuordnung und öffentlich auslösbare Restzahlungen. Ein bloßes Update von October oder PHP beseitigt diese eigenen Implementierungsfehler nicht.

Der Bericht enthält **20 priorisierte Befundgruppen**. Vier sind P0. Die Priorität ist eine Bearbeitungsreihenfolge, kein berechneter CVSS-Wert. Bedingte Auswirkungen sind ausdrücklich gekennzeichnet. Es gibt keinen Nachweis einer bereits erfolgten Kompromittierung.

Zusätzlich liefert der aktuelle Composer-Abgleich **96 Advisory-Einträge für 19 Pakete** im übergeordneten Lockfile. Einträge sind nicht zwingend verschiedene CVEs: Quellen können sich überschneiden. Entwicklungswerkzeuge sind enthalten. Ein Versionsmatch beweist noch keine erreichbare Angriffskette.

## Umfang und Aussagegrenzen

- Rekursive Bestandsaufnahme und musterbasierte Sicherheitsprüfung von **876 Textdateien**: 209 PHP, 221 HTM, 307 JavaScript, 73 CSS, 42 YAML, 4 JSON, 4 Markdown, 13 LESS, 2 SCSS und 1 Ruby-Datei; insgesamt 274.549 Zeilen einschließlich mitgelieferter Bibliotheken und IDE-Hilfen.
- Manuelle Vertiefung der Routen, API-Authentifizierung und Importpfade, Downloads, Eigentümer-AJAX-Handler, Backend-Controller, Buchung und Hobex, SQL-Hilfen, Bewertungsausgabe, Dateiverarbeitung, Logging, Authentifizierung und zentraler Validierung.
- Ergänzend: lokales Anwendungs-`composer.lock`, `composer.json`, `.htaccess` und relevante October-Controller zur tatsächlichen Berechtigungs- und AJAX-Reihenfolge. Die übergeordnete Anwendung wurde nicht vollständig auditiert.
- Automatisiertes Inventar ist **keine manuelle Zeile-für-Zeile-Prüfung sämtlicher Bibliotheken**. Themes, andere Plugins, Serverkonfiguration und sämtliche Drittanbieterinternas sind nicht vollständig abgedeckt. Der Bericht ist eine breite Codeprüfung mit vertieften Angriffspfaden, keine Vollständigkeitsgarantie.
- Keine Kundenserver aufgerufen, keine produktiven Exploits, kein CMS-Bootstrap mit realer Datenbank und keine Buchungen, Zahlungen oder E-Mails ausgelöst. Keine Anwendungskorrekturen vorgenommen.
- Tatsächliche Kundenversionen, Reverse-Proxy-Regeln, WAF, PHP-FPM-Konfiguration, effektive CSRF-/Session-Einstellungen und Datenbankrechte bleiben zu verifizieren. Aussagen zu öffentlicher Erreichbarkeit beziehen sich auf die Registrierung und Prüfungen im vorliegenden Code, sofern nicht anders angegeben.
- `.env`, Zugangsdatenkonfiguration und reale Kundendaten wurden nicht zur Auswertung benötigt. Im Bericht werden keine gefundenen Passwortwerte wiedergegeben.

**Nachweise:** [Composer-Rohdaten](composer-audit-2026-10-26.json), [Dateiinventar mit SHA-256](source-inventory-2026-10-26.json), [aktuelle Regressionstests](verify-isolated.php), [Prüfprotokoll](verification-2026-10-26.txt), [Arbeitsliste](MASSNAHMEN.md).

## Priorisierte Übersicht

| ID | Priorität | Befund | Belegstatus / Voraussetzung |
|---|---|---|---|
| SEC-01 | P0 / kritisch | Beliebige lokale Dateien über `/filedownload` | Code + isolierter Datenflussnachweis; Route erreichbar |
| SEC-02 | P0 / kritisch | SQL-Injection in öffentlichen und geschützten Pfaden | Direkte Quellen/Senken; ein Handler isoliert bestätigt |
| SEC-03 | P0 / kritisch | Fremde erfolgreiche Zahlung kann Buchung bestätigen | Code; gültiger Checkout und Buchungsreferenzen notwendig |
| SEC-04 | P0 / kritisch | Restzahlungen öffentlich auslösbar | Code; fällige Zahlung und konfigurierte Zahlungsanbindung |
| SEC-05 | P1 / hoch | Fehlende Idempotenz bei Callback und Abbuchung | Code; Wiederholung/Parallelität erforderlich |
| SEC-06 | P1 / hoch | Fehlende Backend-Fachberechtigungen | Code + lokaler October-Berechtigungspfad |
| SEC-07 | P1 / hoch | Fehlende Eigentümerprüfung bei Einzeldownload | Code + isolierter Aufruf ohne Authentifizierung |
| SEC-08 | P1 / hoch | Eigentümerdokumente öffentlich, gemeinsame ZIP-Datei | Code; Dateikenntnis bzw. konkurrierende Exporte |
| SEC-09 | P1 / potenziell kritisch | Import akzeptiert beliebige Beleg-Endungen | Code; API-Zugang, PHP-Ausführung zusätzlich serverabhängig |
| SEC-10 | P1 / kritisch bei Formelkontrolle | PHP-`eval` für Kurtaxe | Code + ungefährlicher Funktionsaufruf isoliert bestätigt |
| SEC-11 | P1 / hoch | Gespeichertes XSS in Bewertungen | Code; Veröffentlichung/Freigabe bzw. Import |
| SEC-12 | P1 / hoch | Fest eingebaute gemeinsame Zugangsdaten | Code; Umfang externer Rechte nicht geprüft |
| SEC-13 | P1 / hoch | Buchungssynchronisation vor API-Authentifizierung | Code; offene Buchungen erforderlich |
| SEC-14 | P1 / hoch | Passwörter und personenbezogene Daten in Logs | Code; jeweilige Logoption aktiviert |
| SEC-15 | P1 / hoch | Zahlreiche bekannte PHP-Abhängigkeitslücken | Aktueller Lockfile-Abgleich; Deployment abgleichen |
| SEC-16 | P2 / mittel | Alte JavaScript-Bibliotheken mit bekannten Lücken | Dateiversionen + Hersteller-Advisories; Nutzung prüfen |
| SEC-17 | P2 / mittel bis hoch | Öffentliche Mail-/Rankingaktionen und Missbrauchsschutz | Code; Serverlimits unbekannt |
| SEC-18 | P2 / mittel | Schwache Passwortregeln, Passwortversand per E-Mail | Code; Mailversand optional |
| SEC-19 | P2 / mittel | Unbegrenzte Wartezeiten und ungeschütztes Wiederholen | Code; Netzwerkfehler/Parallelität erforderlich |
| SEC-20 | P2 / mittel | Unbeschränkte PHP-Deserialisierung | Code; Kontrolle über gespeicherte Daten nötig |

## Detaillierte Befunde

### SEC-01 — Beliebiger Dateidownload ohne Anmeldung

**Fundstellen:** `routes.php:16`, `classes/Fewo.php:2267–2285`.

`filepath`, `filename` und `filetype` kommen direkt aus der Query. `Response::download` erhält den Pfad unverändert. Es fehlen Anmeldung, Eigentumsprüfung, Dateireferenz und Beschränkung auf ein erlaubtes Verzeichnis. Die Route ist unabhängig davon registriert, ob das Eigentümer-Frontend verwendet wird.

**Auswirkung:** Für den PHP-Prozess lesbare Dateien können ausgeliefert werden, beispielsweise Anwendungskonfiguration, Schlüssel, Logs oder fremde Dokumente. Die Sperre direkter HTTP-Zugriffe auf `.env` oder `config/` hilft gegen einen durch PHP ausgeführten Download nicht. Lesbarkeit und tatsächlicher Pfad begrenzen den Zugriff.

**Sofortmaßnahme:** Route bis zur Korrektur sperren oder entfernen. Danach nur serverseitig aufgelöste Dokument-ID akzeptieren; Benutzer und Dokumenteigentümer prüfen; private Ablage und `Cache-Control: private, no-store` verwenden. Dateityp aus vertrauenswürdigen Metadaten bestimmen.

**Abnahme:** Anonym 401/403; Benutzer A erhält niemals Dokument B; absolute Pfade, `..` und unbekannte IDs werden verworfen. Isolierter Test bestätigt bereits, dass ein harmloser relativer Testpfad ungeprüft an die Download-Senke gelangt; er liest keine Datei.

### SEC-02 — SQL-Injection an mehreren Eingangsstellen

**Fundstellen und Datenfluss:**

| Eingang | Unsichere Senke | Erreichbarkeit |
|---|---|---|
| URL-`alias` | `components/angebotdetail.php:197–204`, `378–379` | Öffentliche Angebotsseite, sofern eingebunden |
| URL-`alias` | `components/hausdetail.php:147–151` | Öffentliche Hausdetailseite |
| POST-`fileid`, `file` | `components/Daten.php:1805–1811` | Eigentümerkomponente; Handler selbst prüft keinen Login |
| POST-Dateiliste | `components/Daten.php:988`, `1125` | Handler für Eigentümerexport/-mail |
| POST-`checked[]` | `controllers/BookingList.php:100–108`, `118–123`, `132–134` | Backend, zusätzlich SEC-06 |
| POST-`checked[]` | `controllers/RestzahlungenList.php:36–37` | Backend, zusätzlich SEC-06 |
| Objektparameter | `components/Daten.php:1573`, `1628`, `1777–1792` | Eigentümerbuchung |

Die Werte werden als SQL-Text verkettet. HTML-Formulare, erwartete numerische IDs und versteckte Eingaben verhindern manipulierte Requests nicht. Auch authentifizierte API-Dateinamen werden in `classes/Api.php:624–629` ungebunden eingesetzt.

**Auswirkung:** Manipulation von Abfragen und Zugriff auf andere Datensätze; je nach SQL-Kontext und DB-Rechten auch Datenänderungen. Kein pauschaler Nachweis von SQL-basierter Betriebssystemausführung oder Zugriff auf jede Tabelle.

**Korrektur:** Query Builder oder echte PDO-Bindings an sämtlichen Senken; IDs strikt validieren, `whereIn` statt `implode`; Sortierfelder und SQL-Bezeichner durch Allowlist. `Database::execute` (`classes/Database.php:88–94`) ersetzt Platzhalter per `str_replace` und sollte auf echte Bindings umgestellt werden. Wiederholte Textersetzung ist keine saubere Parametrisierung. `Database::escape` verwendet PDO-Quoting; dessen korrekt angewendete Aufrufe sind nicht automatisch SQL-Injection.

**Abnahme:** Regressionstests für Alias mit Apostroph, nichtnumerische IDs, Arrays statt Skalare und manipulierte Mehrfachauswahl. Im isolierten Test wird bei `onDownload` tatsächlich ungefilterte SQL-Syntax aus `fileid` erzeugt; die Abfrage wird vor Ausführung abgefangen.

### SEC-03 — Zahlungsnachweis nicht an die konkrete Buchung gebunden

**Fundstellen:** `routes.php:12`, `classes/HobexRequest.php:35–71`, `classes/Hobex.php:146–168`.

Der Callback sucht eine Buchung anhand `transactionid` und `bookingid`. Unabhängig davon fragt er den über die URL übergebenen Checkout `id` bei Hobex ab. Anschließend genügt ein erfolgreicher Ergebniscode. Es gibt keinen Vergleich des Provider-`merchantTransactionId`, der erwarteten Checkout-ID, des Betrags oder der Währung mit der gefundenen Buchung.

**Auswirkung:** Wer eine gültige erfolgreiche Zahlung und die Referenzen einer Zielbuchung besitzt, kann im vorliegenden Code eine Zahlung einer anderen Buchung zuordnen. Ein frei erfundener Erfolgsstatus allein genügt ausdrücklich nicht: Die Serverabfrage bei Hobex ist vorhanden.

**Korrektur:** Erwartete Checkout-ID serverseitig vorab speichern; Providerantwort mit Buchung, Händler, Betrag, Währung und erlaubtem Statusübergang abgleichen. Abweichung führt zu keiner Buchungsänderung. Geheimnisse oder Sessionwissen allein ersetzen die fachliche Bindung nicht.

**Abnahme:** Provider-Stub mit gültigem Erfolg für Buchung A darf Buchung B nicht bestätigen; falscher Betrag, falsche Währung und unerwarteter Checkout müssen abgelehnt werden. Tests ohne echte Abbuchung.

### SEC-04 — Restzahlungsabbuchung als öffentliche Route

**Fundstellen:** `routes.php:14`, `classes/RestzahlungsManager.php:13–26`, `38–58`, `113–117`.

`Route::any('restzahlung', …)` ruft ohne lokale Authentifizierung die Verarbeitung auf. Diese sucht heute fällige offene Restzahlungen und startet Provider-Zahlungen über gespeicherte Registrierungstokens. Auch Statusmails werden ausgelöst. Es handelt sich nicht nur um eine reine Statusabfrage.

**Auswirkung:** Außenstehende können einen finanziell wirksamen Batch starten. Zusammen mit SEC-05 besteht das Risiko paralleler Mehrfachbelastung. Bereits erledigte Datensätze werden bei einem späteren sequenziellen Aufruf normalerweise ausgefiltert; das verhindert keine gleichzeitigen Aufrufe.

**Korrektur:** Aus dem öffentlichen HTTP-Routing entfernen und als internen Scheduler-/Queue-Job betreiben. Falls HTTP zwingend ist: individuelle signierte Authentifizierung, Replay-Schutz und eingeschränkter Zugriff. Backend-Auslösung separat berechtigen.

**Abnahme:** Anonymer Request führt zu keinem Provideraufruf und keiner Mail; nur berechtigte Jobausführung kann eine Zahlung beanspruchen.

### SEC-05 — Zahlungen und Callbacks sind nicht idempotent

**Fundstellen:** `classes/HobexRequest.php:38`, `66–118`, `148–158`; `classes/RestzahlungsManager.php:38–58`, `126–137`.

Der Callback begrenzt den Eingang nicht auf eine noch unbestätigte Buchung. Wiederholter Erfolg schreibt erneut Belegung und gegebenenfalls Restzahlung und sendet erneut E-Mails. Der Restzahlungsjob liest offene Datensätze, ruft danach den Provider auf und markiert sie erst anschließend als bezahlt. Eine atomare Reservierung vor dem Provideraufruf fehlt.

**Auswirkung:** Doppelte lokale Vorgänge, Mails und mögliche doppelte Belastungen. Ob der Provider bestimmte Duplikate zusätzlich abfängt, wurde nicht verifiziert; darauf sollte die Anwendung nicht vertrauen.

**Korrektur:** Persistenter Zahlungsversuch mit eindeutiger fachlicher ID, atomarer Statuswechsel vor dem Aufruf, Unique Constraints, Provider-Idempotenz soweit unterstützt. Unklare Netzwerkresultate als prüfbedürftig speichern; erst Status ermitteln, dann über Wiederholung entscheiden. Bestätigungsfolgen genau einmal ausführen.

**Abnahme:** Zweimal gleicher Callback und zwei gleichzeitige Worker ergeben genau einen Zahlungsvorgang/eine Belegung; Timeout nach Annahme beim Provider verursacht keine automatische zweite Abbuchung.

### SEC-06 — Fachliche Backend-Berechtigungen fehlen

**Fundstellen:** `controllers/BookingList.php:20–34`, `controllers/RestzahlungenList.php:17–41`, `controllers/BookingAsk.php:12`, `controllers/Votings.php:13`, `controllers/AusstattungSet.php:12`.

Diese Controller definieren keine `requiredPermissions` und ihre eigenen gefährlichen Handler prüfen keine Fachrechte. Die lokale October-Basisklasse prüft zwar Backend-Anmeldung und `general.backend`, aber controllerbezogene Rechte nur, wenn `requiredPermissions` gefüllt ist (`modules/backend/classes/Controller.php:201–215`). Menüberechtigungen in `Plugin.php` schützen keine direkte Controller-URL.

**Auswirkung:** Ein eingeschränkter Backend-Nutzer kann über direkte Aufrufe Zugriff auf Buchungen, Lösch-/Versandaktionen und Zahlungsauslösung erhalten, obwohl die Oberfläche diese Bereiche ausblendet. Es ist kein anonymer Backend-Zugang.

**Korrektur:** Explizite Rechte für Lesen, Bearbeiten, Löschen, erneutes Senden und Zahlungen; Controller und Handler absichern. Bereits geschützte Controller wie `Galleries`/`Users` als konsistentes Muster nutzen.

**Abnahme:** Testnutzer nur mit `general.backend` erhält für diese Bereiche 403; ein Leserecht erlaubt keine Zahlungs-/Löschaktionen.

### SEC-07 — Einzeldownload prüft weder Anmeldung noch Eigentümer

**Fundstellen:** `components/Daten.php:427–428`, `1805–1813`; lokale October-AJAX-Ausführung in `modules/cms/classes/Controller.php:374–384`.

`onDownload` nimmt Eigentümer-/Attachment-ID und Dateinamen aus POST, sucht das Dokument und leitet auf die öffentliche Datei weiter. Weder `Auth::check()` noch Bindung an den angemeldeten Eigentümer sind vorhanden. Der Logincheck in `onRun` genügt nicht: Im geprüften October wird AJAX vor dem normalen Seitenlebenszyklus abgearbeitet; ein bloßes `return` ist ohnehin keine zentrale Autorisierung.

**Auswirkung:** Fremde Abrechnungen bei Kenntnis ihrer Referenzen; SQL-Injection aus SEC-02 verschärft dies. Eine zusätzliche Schutzkomponente im kundenspezifischen Theme könnte einzelne Seiten absichern, ersetzt aber keine Handlerprüfung.

**Korrektur:** Authentifizierung und dokumentbezogene Policy direkt vor jeder Datenoperation. Alle Eigentümerhandler derselben Prüfung unterziehen. Besonders `onBtnBuchen` übernimmt `objekt` aus dem Request (`1555–1574`) ohne ausdrückliche abschließende Eigentumsfreigabe; mögliche indirekte Filter in Preisfunktionen sind kein Ersatz. Die vollständige Fremdobjektbuchung ist als gesonderter Integrationstest offen.

**Abnahme:** Kein Handler liest/verändert Daten für einen anderen Eigentümer; direkter AJAX-Aufruf ohne normale Seitendarstellung bleibt geschützt.

### SEC-08 — Vertrauliche Abrechnungen in öffentlichem Storage

**Fundstellen:** `classes/Api.php:499–515`, `539–555`, `587–603`, `644–660`; `classes/Datei.php:39`, `72–83`; `components/Daten.php:1009–1021`, `1152–1185`.

Abrechnungs- und Eigentümerdokumente werden mit `is_public = 1` und unter `/storage/app/uploads/public/` gespeichert. Die lokale `.htaccess` lässt diesen Dateibereich ausdrücklich zu. Hashdateinamen ersetzen keine Benutzerberechtigung. Exporte verwenden zudem installationsweit denselben Pfad `storage/app/uploads/document.zip`.

**Auswirkung:** Jeder Besitzer eines Dokumentlinks kann die Datei ohne Eigentümerprüfung abrufen. Gleichzeitige Exporte können sich überschreiben oder falsche Unterlagen ausliefern. Die ZIP selbst wird von der lokalen Standard-Whitelist nicht direkt freigegeben; ein pauschaler öffentlicher Direktzugriff darauf wird hier nicht behauptet. SEC-01 eröffnet allerdings einen separaten Downloadpfad.

**Korrektur:** Abrechnungen privat speichern, vorhandene Dateien und Verweise migrieren, alte öffentliche Kopien entfernen. Pro Export zufälliger privater temporärer Pfad, Berechtigungsprüfung und anschließende Bereinigung. Öffentliche Objektbilder können öffentlich bleiben.

**Abnahme:** Alte Dokument-URLs funktionieren nicht mehr; zwei parallele Exporte liefern jeweils ausschließlich die richtigen Unterlagen.

### SEC-09 — Beliebige Dateiendung beim Belegimport

**Fundstellen:** `classes/Api.php:620–660`, `classes/Datei.php:72–83`; SVG-Import `classes/Api.php:1983–2004`.

`BELEG->NAME` bestimmt die Dateiendung. Der base64-dekodierte Inhalt wird ohne passende Endungs-Allowlist, belastbare Inhaltsprüfung oder Umkodierung gespeichert. Auch SVG-Inhalte werden ungefiltert übernommen.

**Auswirkung:** Ein berechtigter oder kompromittierter Importclient kann aktive Inhalte ablegen. Servercodeausführung bei einer PHP-Dateiendung ist **serverabhängig**: Die vorhandene Apache-Regel blockiert direkte `.php`-Aufrufe; PHP-FPM-/Nginx-Regeln und alternative ausführbare Endungen wurden nicht geprüft. Aktive HTML-/SVG-Dateien können zusätzliche XSS-Pfade schaffen.

**Korrektur:** Nur fachlich erlaubte Formate; Endung und MIME aus validiertem Inhalt, Größenlimits, private Belegablage; Bilder neu kodieren, SVG sanitizen oder deaktivieren. Script-Ausführung in sämtlichen Uploadbereichen serverseitig sperren.

**Abnahme:** PHP/HTML, Doppelendungen, unbekannte MIME-Typen und SVG mit Skript/Ereignisattributen werden abgelehnt. Nur künstliche Testdateien verwenden.

### SEC-10 — Kurtaxenformel führt PHP-Code aus

**Fundstellen:** `classes/Api.php:2544`, `classes/Booking.php:851–897`.

Importierte `FORMEL` wird als `tz_formel` gespeichert, Platzhalter werden ersetzt, danach wird der Rest mit `eval('return ' . $ausdruck . ';')` ausgeführt. Die Prüfung auf nicht ersetzte eckige Platzhalter beschränkt PHP-Funktionsaufrufe nicht.

**Auswirkung:** Wer eine solche Formel kontrolliert, kann PHP-Code mit den Rechten des Webprozesses ausführen. Kontrolle ist über den autorisierten Import oder andere Datenmanipulation denkbar. Eine direkte anonyme Formelübermittlung wurde nicht nachgewiesen. Der isolierte Test verwendet nur `strlen('audit')` und bestätigt das unerlaubte Ausführen einer PHP-Funktion.

**Korrektur:** `eval` vollständig entfernen. Kleinen arithmetischen Parser mit explizit erlaubten Operatoren und typisierten Variablen einsetzen; keine PHP-Funktionsnamen, Attribute oder beliebigen Aufrufe. Bestehende Formeln vor Migration auf Kompatibilität prüfen.

**Abnahme:** Fachlich gültige Formeln rechnen korrekt; jeder Funktionsaufruf wird vor Auswertung abgelehnt.

### SEC-11 — Gespeichertes XSS über Bewertungen

**Fundstellen:** `components/objektbewerten.php:179–202`; `components/bewertungen.php:376–383`; `components/bewertungen/default.htm:6`, `23–25`; `components/objektbewslider.php:478–493`, `components/objektbewslider/item.htm:18–20`.

Gäste können Betreff, Nachricht und Namen liefern. Diese werden unverändert gespeichert und später teilweise nur mit Zeilenumbruchersetzung an Twig übergeben. Die Templates verwenden `|raw` für genau diese Inhalte. Veröffentlichung kann eine Freigabe (`aktiv = 1`) erfordern; sie entfernt schädliches HTML nicht automatisch.

**Auswirkung:** JavaScript läuft im Ursprung der Website, sobald eine schädliche Bewertung veröffentlicht/angezeigt wird. Das kann Besucheraktionen und Daten in diesem Ursprung betreffen. Kein nachgewiesener automatischer Backend-Account-Takeover.

**Korrektur:** Nutzereingaben standardmäßig escapen; Zeilenumbrüche nach Escaping formatieren. Nur dort, wo fachlich HTML notwendig ist, serverseitige Allowlist-Sanitisierung. Auch vorhandene Bewertungen und importierte Inhalte behandeln.

**Abnahme:** Harmloser HTML-/Ereignisattribut-Test erscheint als Text bzw. wird entfernt, auch nach Moderationsfreigabe und im Slider.

### SEC-12 — Gemeinsame Secrets im Quelltext und Query-String

**Fundstellen:** `classes/Feondi.php:19–21`, Konstanten in `formwidgets/SyncFeondiActivation.php`; `classes/Preislevel.php:62–66`; Debugzugang `classes/RestzahlungsManager.php:143–149`, `classes/SendCron.php:394`.

Gemeinsame HTTP-Zugangsdaten und ein festes Passwort für Preislevel-Updates stehen im ausgelieferten Code. Preislevel authentifiziert über GET-Parameter; das hinterlässt Geheimnisse potenziell in Accesslogs. Ein gemeinsamer Debugwert schaltet Detailausgaben frei.

**Auswirkung:** Kenntnis einer Kopie des Codes reicht zur Kenntnis dieser Werte. Was die externe Feondi-Gegenstelle damit tatsächlich erlaubt, wurde nicht getestet; deshalb kein pauschaler Cross-Tenant-Zugriffsnachweis.

**Korrektur:** Gemeinsame Zugangsdaten koordiniert ersetzen und rotieren; individuelle, widerrufbare Credentials mit begrenztem Zweck und sicheren Headern. Debugausgaben nur über autorisierte interne Wege. Secrets nicht in diesem Bericht oder Tickets kopieren.

**Abnahme:** Alte Werte werden abgewiesen; installatonsfremde Credentials funktionieren nicht; URLs enthalten keine Secrets.

### SEC-13 — Synchronisation vor Loginprüfung

**Fundstellen:** `classes/Api.php:94–106`, `3616–3636`.

Allein die Existenz von `Login->Feondi` löst `checkBookings()` aus. Erst danach folgt der Vergleich von Username und Passwort. `checkBookings()` kann Buchungen an Feondi übertragen und lokale Synchronisationszustände verändern.

**Auswirkung:** Nicht angemeldete Aufrufer können ausgehende Synchronisation triggern, sofern passende offene Buchungen vorhanden sind. Keine Behauptung, dass der gesamte Import damit ohne Passwort freigeschaltet ist.

**Korrektur:** Erst Login vollständig und bei fehlender Konfiguration ablehnend prüfen, dann autorisierte Operation ausführen. Import-/Heartbeat-Aufgaben voneinander trennen, Rate Limits und Replaykontrolle ergänzen.

**Abnahme:** Ungültige, leere oder fehlende Credentials verursachen null DB-Änderungen und null ausgehende Requests.

### SEC-14 — Secrets und personenbezogene Inhalte werden unredigiert protokolliert

**Fundstellen:** `classes/Api.php:100–104`; `classes/Feondi.php:34–37`; `formwidgets/SyncFeondiActivation.php:202–203`; `classes/SessionManager.php:55–58`; `classes/Logger.php:83–86`; `classes/HobexRequest.php:54`.

Import-XML enthält Loginfelder und kann komplett protokolliert werden; außerdem werden Buchungs-XML, Sessionwerte und Providerantworten geloggt. Der Logger maskiert keine sensitiven Felder.

**Auswirkung:** Personenbezogene Daten, Credentials und Zahlungsreferenzen werden in Logs vervielfältigt und für Logberechtigte/Backups zugänglich. Aktivierung hängt von den jeweiligen Logflags ab; der Fehler ist nicht die bloße Existenz eines Loggers.

**Korrektur:** Strukturierte Ereignisse mit Referenz-IDs; Allowlist sicherer Felder und zentrale Redaktion. Historische Logs auf sensible Inhalte prüfen, Aufbewahrung begrenzen und tatsächlich exponierte Credentials rotieren.

**Abnahme:** Tests mit eindeutig markierten Testpasswörtern/IBANs finden diese Marker in keinem Log oder Fehlerbericht.

### SEC-15 — Bekannte Schwachstellen der festgeschriebenen PHP-Pakete

**Fundstelle:** `D:/Entwicklung/fewoverwalter/composer.lock`; vollständige aktuelle Ergebnisse in `composer-audit-2026-10-26.json`.

Lokale Versionen: October-System/Backend/CMS `3.5.7`, Rain `3.5.6`, Laravel `9.52.16`, Twig `3.8.0`, Symfony HttpFoundation `6.3.8`. Plugin-Code und Lockfile können unterschiedliche Entwicklungsstände repräsentieren. Ein Kundenserver mit October 4 ist deshalb nicht automatisch von diesem Lockfile-Befund betroffen.

| Paket | Advisory-Einträge | Paket | Advisory-Einträge |
|---|---:|---|---:|
| composer/composer | 12 | guzzlehttp/guzzle | 9 |
| guzzlehttp/psr7 | 4 | laravel/framework | 7 |
| league/commonmark | 15 | league/flysystem | 1 |
| nesbot/carbon | 1 | october/rain | 3 |
| october/system | 12 | phpunit/phpunit | 1 |
| psy/psysh | 1 | symfony/http-foundation | 3 |
| symfony/mailer | 1 | symfony/mime | 2 |
| symfony/polyfill-intl-idn | 1 | symfony/process | 1 |
| symfony/routing | 2 | symfony/yaml | 4 |
| twig/twig | 16 | **Gesamt** | **96** |

Beispiele aus dem Versionsabgleich: Laravel CVE-2024-52301 (Umgebungsmanipulation), October Rain CVE-2026-22692 (Twig-Sandbox-Bypass), Twig CVE-2024-45411 (Sandbox-Bypass), HttpFoundation CVE-2025-64500 (PATH_INFO/Autorisierung). Die jeweiligen Voraussetzungen sind pro Deployment zu prüfen. Laravel 9 erhält laut [offizieller Supporttabelle](https://laravel.com/framework/docs/10.x/releases) seit 06.02.2024 keine regulären Sicherheitsupdates mehr.

**Korrektur:** Unterstützten October-/PHP-Stand auswählen, kompatible Abhängigkeiten aktualisieren und alle Kunden-Lockfiles gegen aktuelle Advisories prüfen. Pakete nicht blind einzeln auf inkompatible Majors setzen. Build-/Dev-Tools getrennt vom Webruntime-Risiko bewerten; Produktionsinstallation ohne unnötige Entwicklungsabhängigkeiten.

**Abnahme:** Vollständiger Audit erfolgreich ausgeführt; verbleibende Treffer einzeln mit Erreichbarkeit und Entscheidung dokumentiert. Die hier gespeicherten 96 Einträge sind kein erfolgreicher Sicherheitsfreigabestatus.

### SEC-16 — Alte Frontend-Bibliotheken und veränderliche CDN-Versionen

**Fundstellen:** `assets/js/jquery.slim.min.js:1` (jQuery 3.4.1), `assets/js/jquery-ui.js:1` (UI 1.12.1); UI-Einbindung `components/objekttextsearch.php:103` und `components/buchungsmaske.php:302`; CDN-Einbindung `components/Daten.php:412–413`, `components/Account.php:136–139`.

jQuery 3.4.1 liegt im betroffenen Bereich von [CVE-2020-11022](https://github.com/jquery/jquery/security/advisories/GHSA-gxr4-xjj5-5px2). UI 1.12.1 liegt im betroffenen Bereich von [CVE-2021-41182](https://github.com/jquery/jquery-ui/security/advisories/GHSA-9gj3-hwp5-pmwc). Diese XSS-Lücken benötigen passende unsichere Datenflüsse in DOM-Methoden/Widgetoptionen; das reine Vorhandensein einer Datei beweist keine Ausnutzung. Ob die separate jQuery-Slim-Datei im jeweiligen Theme geladen wird, bleibt offen. `vue@3` lädt zudem eine bewegliche Version.

**Korrektur:** Tatsächlich geladene Bundles inventarisieren, kompatible gepflegte Versionen festschreiben, ungenutzte Alt-/Testkopien entfernen, CDN-Ressourcen fest pinnen oder selbst ausliefern. DOM-Eingaben escapen; Updates ersetzen dies nicht.

**Abnahme:** Browser-Bundleprüfung pro Frontendvariante; Buchung, Kalender, Suche und Eigentümeransicht funktionieren mit aktualisierten Bibliotheken.

### SEC-17 — Öffentliche Verwaltungsaktionen und fehlende lokale Missbrauchsgrenzen

**Fundstellen:** `routes.php:9`, `15`; `classes/SendCron.php:110–150`; `classes/ObjektRanking.php:11–13`; `components/objektbewerten.php:179–274`; API-Body-Lesen `classes/Api.php:67–79`.

`/cron` kann Mailverarbeitung anstoßen; `/objectranking` schreibt Rankings ohne Anmeldung. Bewertungsabgabe hat keine erkennbare lokale Rate-Limit-/Buchungsnachweisprüfung und schreibt/sendet direkt. Der API-Body wird vor Authentifizierung vollständig eingelesen und geparst; Limits werden vollständig der Infrastruktur überlassen. Für öffentliche Buchungs-/Anfragehandler ist ebenfalls keine zentrale lokale Drosselung sichtbar.

**Auswirkung:** Spam, unnötige externe Aktionen, Rankingmanipulation und Ressourcenverbrauch. Die genaue Lastgrenze hängt von Webserver und Daten ab. CSRF-Schutz allein verhindert anonyme Automatisierung nicht.

**Korrektur:** Wartungsaktionen intern planen; zustandsändernde GET-Aufrufe entfernen; Rate Limits nach IP und fachlicher Identität, Größen-/Mengenlimits und verifizierte Bewertungslinks. Prüfungen vor teurer Verarbeitung und vor Mailversand durchführen.

**Abnahme:** Unberechtigte Aktionen verweigert, Überlast 429/413, übergroße XML-Eingaben vor Parsing gestoppt; gültige Kundenabläufe bleiben möglich.

### SEC-18 — Passwortlebenszyklus für Eigentümer verbessern

**Fundstellen:** `models/User.php:27–28`, `373`; `components/Account.php:269`, `289`; `classes/Api.php:370–389`; `views/mail/eigentuemerNeu_de.htm:8`, `views/mail/eigentuemerGeaendert_de.htm:7`.

Die Modellvalidierung erlaubt vier Zeichen, die Zufallsvergabe erzeugt sechs Zeichen. Optionale Einladungs-/Änderungsmails enthalten das eigentliche Passwort. Login erfolgt mit dauerhaftem Erinnern (`authenticate(..., true)`). Positiv: Importpasswörter werden mit `Hash::make` gespeichert; Throttling ist in `EgSettings::initSettingsData` standardmäßig aktiviert. Deshalb kein Befund „alle Passwörter liegen unverschlüsselt in der Benutzertabelle“ oder „Login hat generell keine Drosselung“.

**Korrektur:** Ausreichende Mindestlänge und längere zufällige Initialwerte, besser einmaliger zeitbegrenzter Einladungs-/Resetlink. Persistente Anmeldung bewusst auswählbar; Sitzungen nach Passwortänderung widerrufen. Effektives Throttling einschließlich Proxy-IP-Erkennung prüfen.

**Abnahme:** Schwache neue Passwörter zurückweisen; E-Mails enthalten keine dauerhaften Passwörter; alte Sitzungen verlieren nach Reset ihre Berechtigung.

### SEC-19 — Externe Requests ohne explizite Zeitgrenzen; Wiederholung unklarer Ergebnisse

**Fundstellen:** `classes/Hobex.php:117–124`, `159–168`; `classes/Fewo.php:2203–2211`; `classes/Feondi.php:39–48`.

cURL-Aufrufe setzen keine ausdrücklichen Verbindungs-/Gesamttimeouts. Feondi-Übertragung kann dreimal laufen; lokale Reservierung erfolgt erst nach dem ersten Netzaufruf. Unklare Ergebnisse werden nicht als eigener dauerhafter Zustand behandelt.

**Auswirkung:** Blockierte PHP-Worker bei langsamen Gegenstellen; konkurrierende oder wiederholte Übertragungen. Das tatsächliche Duplikatverhalten der Gegenstelle ist offen. TLS-Zertifikatsprüfung ist bei Hobex ausdrücklich aktiv und wird nicht als deaktiviert beanstandet.

**Korrektur:** Begrenzte Timeouts, persistente Jobreservierung und fachliche Transfer-ID. Bei unklarer Annahme Statusabgleich statt blindem Wiederholen; Circuit Breaker nur bei konkretem Bedarf.

**Abnahme:** Simulierter Verbindungsstillstand endet innerhalb des definierten Budgets; zwei Worker senden denselben Vorgang nicht parallel.

### SEC-20 — Unbeschränkte Deserialisierung gespeicherter Daten

**Fundstellen:** `classes/Booking.php:371`, `429–431`; `classes/Fewo.php:2092`, `2118`, `2139`; `components/objektstammdaten.php:410`.

`unserialize` wird ohne `allowed_classes => false` auf gespeicherte Felder angewandt. Mehrere Werte werden regulär serverseitig serialisiert; direkte anonyme Kontrolle über jedes Feld wurde nicht nachgewiesen.

**Auswirkung:** Bei zusätzlicher Kontrolle über solche Felder können PHP-Objekte instanziiert werden. Für tatsächliche Codeausführung wären zusätzlich passende Klassen/Gadgetketten erforderlich; diese wurden nicht nachgewiesen.

**Korrektur:** Für reine Daten JSON und explizite Schemas verwenden. Übergangsweise Klassen verbieten, Typ und Größe prüfen und alte Einträge geordnet migrieren.

**Abnahme:** Objektdeskriptoren werden abgewiesen; bestehende Buchungen und Ausstattungen bleiben nach Migration lesbar.

## Weitere Prüfpunkte ohne bestätigte Exploitkette

- **XML/XXE:** `simplexml_load_string` nutzt `LIBXML_NOCDATA`, nicht `LIBXML_NOENT`. Deshalb kein pauschaler XXE-Befund allein aufgrund von SimpleXML. DTD-/Entity-Verhalten des tatsächlich eingesetzten libxml, Netzwerkzugriff und Größenlimits trotzdem negativ testen.
- **Frontend-CSRF:** Effektive October-/Theme-Middleware in jeder Kundenversion prüfen. Aus fehlenden Tokenprüfungen in einzelnen Komponenten wird keine universelle CSRF-Lücke abgeleitet. Öffentliche mutierende GET-Routen sind unabhängig davon problematisch.
- **Session/Cookies/HTTPS:** Laufzeitwerte für Secure, HttpOnly, SameSite, vertrauenswürdige Proxys und Hostvalidierung offen. `SessionManager::getSessionCode` verwendet `HTTP_HOST`; Host-Header dürfen nicht ungeprüft Vertrauensentscheidungen steuern.
- **Buchungsintegrität:** Objektzuordnung, Mengenobergrenzen, negative/überlange Aufenthalte, parallele Verfügbarkeitsprüfung und Abschlusszustände mit Integrationsfällen absichern. Das Frontend ist keine fachliche Autorisierungsgrenze.
- **Private Zahlungsabschlussseite:** `components/paid.php:61–89` liefert personenbezogene Daten allein nach Payment-ID. Entropie, URL-Leaks, Referrer-Policy und Ablauf prüfen; kein Nachweis, dass Provider-IDs erratbar sind.
- **Serverdateien:** Lokales `info.php` enthält `phpinfo()`, wird aber von der vorhandenen `.htaccess` gegen direkte PHP-Aufrufe erfasst. Effektiven Schutz bei Nginx/abweichender Konfiguration prüfen und unnötige Diagnose-/Archivdateien aus Deployments ausschließen.
- **Dateilöschung:** `Datei::deleteFile` entfernt alle Dateien im berechneten Partitionsordner statt nur die referenzierte Datei. Kollisions-/Datenverlustrisiko prüfen; kein belegter anonymer Löschpfad.
- **Testabdeckung:** Vorhandene Plugin-Tests konzentrieren sich auf Preise/Zeitleisten. Berechtigungs-, Download-, SQL-, XSS- und Zahlungszustandstests ergänzen. Die isolierten Prüfnachweise dieses Audits ersetzen keine Framework-Integrationstests.

## Empfohlene Reihenfolge

1. **Unmittelbare Eindämmung:** SEC-01 sperren, SEC-04 aus öffentlichem Routing nehmen, öffentliches SQL-Risiko SEC-02 beheben. Callback SEC-03 korrigieren; bis dahin den betroffenen Zahlungsablauf kontrolliert einschränken. Änderungen an Kundenservern separat planen und testen.
2. **Vertrauensgrenzen herstellen:** SEC-05 bis SEC-14, zuerst Backend-/Eigentümerrechte und private Unterlagen. Formel- und Dateiformatgrenzen schließen. Zugangsdaten erst nach Schließen der Leckpfade koordiniert rotieren.
3. **Abhängigkeiten und Prävention:** SEC-15/16 parallel vorbereiten; kompatiblen Upgradepfad testen. Missbrauchsschutz, Passwortlebenszyklus, Timeout-/Transferzustände und Datenmigration ergänzen.
4. **Freigabe pro Kundentyp:** Normale und alternative Buchungs-/Eigentümermasken, verwendete Komponenten, October-/PHP-Version und Webserverkonfiguration erfassen. Negative Tests mit anonym, Eigentümer A/B und eingeschränktem Backendnutzer durchführen.

Für die Umsetzung passen kleine Dienste für Dokumentzugriff, Eigentümerautorisierung, Zahlungszustände, Importvalidierung und sichere Formelauswertung in die bestehenden Abläufe. Kein vollständiger Architekturumbau als Voraussetzung für Sofortfixes. Neue Funktionen klar begrenzen und entsprechend Projektvorgabe mit Komplexität höchstens 5 gestalten.

## Reproduzierbarkeit

Die Referenzzeilen gelten für den oben genannten Commit. Das Inventar erfasst Dateihashes des geprüften Pluginstands vor Erstellung dieses Berichts.

```powershell
# Im Pluginverzeichnis: arbeitet ausschließlich mit Stubs, ohne CMS-Bootstrap.
php docs/security/verify-isolated.php

# In der übergeordneten Anwendung: liest das Lockfile und fragt Advisories ab.
composer --no-plugins --no-scripts audit --locked --format=json
```

Der erste Composer-Versuch scheiterte an der Netzwerkbegrenzung; der anschließende freigegebene Leseabruf war erfolgreich. Audit-Exitcode 1 bedeutet hier gefundene Warnungen, nicht fehlgeschlagene Auswertung. Es wurden keine Pakete installiert oder aktualisiert. Isolierte Verifikation: vier Bestätigungen, Exitcode 0. Es handelt sich um Nachweise vorhandener Schwächen; nach Korrektur müssen die Tests auf sichere Ablehnung umgestellt werden.
