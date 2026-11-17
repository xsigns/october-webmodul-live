# Webmodul-Update veröffentlichen

Den Ordner **`D:\Entwicklung\ioncube_fewo_oct`** öffnen und die Batch-Dateien aus Schritt 1 bis 5 **nacheinander per Doppelklick** ausführen. Anschließend Schritt 6 im Browser durchführen.

| Schritt | Datei ausführen / Aktion | Ergebnis |
| --- | --- | --- |
| 1 | `01_version_pruefen.bat` | Prüft, ob eine neue Versionsnummer vorhanden ist. |
| 2 | `02_quelldateien_kopieren.bat` | Kopiert die Quelldateien ins ionCube-Projekt. |
| 3 | `03_webmodul_verschluesseln.bat` | Verschlüsselt das Webmodul mit dem ionCube Encoder. |
| 4 | `04_live_projekt_aktualisieren.bat` | Kopiert die verschlüsselten Dateien ins Live-Projekt und überschreibt vorhandene Dateien. |
| 5 | `05_release_veroeffentlichen.bat` | Erstellt auf `master` den Commit `update <Version>`, setzt den Tag `v<Version>` und pusht beides. |
| 6 | [October-Plugin-Updates öffnen](https://octobercms.com/account/plugin/updates/893), bei October einloggen und auf **Pull in Build** klicken. | Veröffentlicht das Update im October Marketplace. |

**Vor dem Start:** Die neue Version muss in `updates\version.yaml` des Quellprojekts eingetragen sein. Im Live-Projekt muss `master` aktiv sein; alle dortigen Änderungen müssen zum Update gehören.

**Nach jedem Schritt:** Den Abschluss abwarten und die Ausgabe prüfen. Nur bei Erfolg die nächste Datei starten. Bei einem Fehler anhalten.

**Bei `03_webmodul_verschluesseln.bat`:** Die Datei meldet Erfolg erst nach allen drei erfolgreichen Encoder-Aufrufen. Bei einem Fehler bricht sie mit einer Fehlermeldung ab. Das Fenster wartet anschließend auf einen beliebigen Tastendruck. Die Kopierdatei aus Schritt 2 prüft ihre Fehler weiterhin nicht durchgehend automatisch.

**Schritt 5 überträgt das Update nach GitHub. Für die Veröffentlichung im October Marketplace anschließend Schritt 6 ausführen.**

Bei einem erneuten Export aus ionCube als Dateinamen ebenfalls `03_webmodul_verschluesseln.bat` verwenden und danach die ergänzte Fehlerprüfung, Abschlussmeldung und Tastendruck-Pause wieder übernehmen.
