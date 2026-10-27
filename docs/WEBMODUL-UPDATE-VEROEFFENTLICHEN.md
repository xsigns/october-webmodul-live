# Webmodul-Update veröffentlichen

Diese Anleitung beschreibt die Veröffentlichung eines Webmodul-Updates und wird schrittweise ergänzt.

## 0. Neue Versionsnummer vorab prüfen

Vor dem Kopieren `D:\Entwicklung\ioncube_fewo_oct\check_webmodul_version.bat` per Doppelklick starten. Die Prüfung liest die höchste Version aus dem ursprünglichen Quellprojekt unter `D:\Entwicklung\fewoverwalter\plugins\xsigns\fewo\updates\version.yaml`, nicht aus einer möglicherweise älteren Encoder-Kopie.

Sie vergleicht diese Version mit den lokalen Tags und den direkt von `origin` gelesenen Tags des Live-Projekts. Nur eine numerisch höhere Version wird akzeptiert. Die vorhandenen Tagformate `vX.Y.Z`, `VX.Y.Z`, `v.X.Y.Z` und `X.Y.Z` werden berücksichtigt. Bei einer gleichen oder älteren Version muss zuerst die neue Versionsnummer im Quellprojekt eingetragen werden. Bei einem Git- oder Verbindungsfehler gilt die Prüfung als fehlgeschlagen.

Alternativ in PowerShell:

```powershell
& 'D:\Entwicklung\ioncube_fewo_oct\release_webmodul.ps1' -CheckVersion
```

Die Vorprüfung verändert weder Dateien noch Git-Referenzen und führt keinen Encoder-Lauf aus. Rückgabecode `0` bedeutet, dass eine neue Version vorhanden ist; `1` bedeutet Abbruch. Erst nach erfolgreicher Prüfung mit Schritt 1 beginnen. Die Versionsprüfung wird beim späteren Release erneut ausgeführt.

## 1. Batch-Datei im ionCube-Projekt ausführen

Das Verzeichnis `D:\Entwicklung\ioncube_fewo_oct` ist ein eigenständiges Projekt.

1. Den Ordner `D:\Entwicklung\ioncube_fewo_oct` im Windows-Explorer öffnen.
2. Die Datei `copy_fewo_to_ioncube.bat` einmal per Doppelklick ausführen.

## 2. Projekt mit dem ionCube Encoder vollständig neu bauen

Nach dem Kopieren das Projekt `D:\Entwicklung\ioncube_fewo_oct\fewo.iep` mit dem ionCube Encoder vollständig neu bauen. Dabei werden die zur Kodierung konfigurierten Dateien erneut verschlüsselt; die im Projekt festgelegten Kopierregeln bleiben wirksam.

In der Projektdatei sind diese Verzeichnisse hinterlegt:

| Zweck | Verzeichnis |
| --- | --- |
| Quelldateien aus Schritt 1 | `D:\Entwicklung\ioncube_fewo_oct\fewoverwalter` |
| Ausgabe des Encoders | `D:\Entwicklung\ioncube_fewo_oct\ioncube\fewoverwalter-new` |

### Neubau über die Anwendung

1. `fewo.iep` im ionCube Encoder öffnen.
2. Über **Build > Build (Rebuild)** den vollständigen Neubau starten; alternativ **F5** drücken. Auf den Modus **Rebuild** achten.
3. Den erfolgreichen Abschluss ohne Fehler abwarten. Das Ergebnis wird automatisch im oben angegebenen Ausgabeverzeichnis abgelegt.

### Encoder per Batch-Datei ohne Oberfläche ausführen

Die exportierte Batch-Datei liegt bereits unter `D:\Entwicklung\ioncube_fewo_oct\fewo.bat`. Nach Schritt 1 diese Datei starten und den erfolgreichen Abschluss aller Encoder-Aufrufe prüfen.

Aufruf in PowerShell:

```powershell
& 'D:\Entwicklung\ioncube_fewo_oct\fewo.bat'
```

**Stand der Prüfung vom 27.10.2026:** `fewo.bat` wurde aus `fewo.iep` exportiert und ruft die Encoder für PHP 7.4, 8.1 und 8.2 aus ionCube Pro PHP Encoder 14.0.2 auf. Der erste Aufruf erzeugt ein Bundle; die beiden folgenden ergänzen es. Quell- und Zielpfad entsprechen der Tabelle oben. Im Rahmen dieser Dokumentation wurde die Batch-Datei gelesen, aber kein Encoder-Lauf ausgeführt.

Bei Änderungen an den Projekteinstellungen `fewo.bat` über **Project > Export… > Windows batch file** erneut exportieren.

Die aktuelle Exportdatei enthält noch keine Fehlerprüfung zwischen den drei Encoder-Aufrufen. Für eine durchgehende automatische Veröffentlichung muss bei jedem fehlgeschlagenen Encoder-Aufruf abgebrochen werden, bevor weitere Encoder-Aufrufe, Kopieren oder Veröffentlichen folgen. Eine übergeordnete Batch-Datei, die alle vier Schritte mit Fehlerprüfung verbindet, ist bisher nicht angelegt.

Quellen: [ionCube: Projekte exportieren](https://www.ioncube.com/sa/gui_docs/project_export.html), [ionCube: Projekt neu bauen](https://www.ioncube.com/sa/gui_docs/quickstart.html).

## 3. Encoder-Ausgabe in das Live-Projekt kopieren

Nach dem erfolgreichen Neubau den vollständigen Inhalt von `D:\Entwicklung\ioncube_fewo_oct\ioncube\fewoverwalter-new` nach `D:\Entwicklung\ioncube_fewo_oct\ioncube\october-webmodul-live` kopieren, einschließlich aller Unterverzeichnisse. Die Dateien liegen danach direkt im Zielordner; es wird kein zusätzlicher Unterordner `fewoverwalter-new` angelegt. Vorhandene Dateien werden überschrieben. Dateien, die nur im Ziel vorhanden sind, bleiben erhalten.

Für diesen Schritt ist die Batch-Datei `D:\Entwicklung\ioncube_fewo_oct\copy_ioncube_to_live.bat` angelegt:

1. Sicherstellen, dass Schritt 2 erfolgreich abgeschlossen ist.
2. `copy_ioncube_to_live.bat` einmal per Doppelklick ausführen.
3. Den Abschluss im geöffneten Fenster prüfen. Bei einem Kopierfehler wird eine Fehlermeldung ausgegeben.

Alternativ in PowerShell starten:

```powershell
& 'D:\Entwicklung\ioncube_fewo_oct\copy_ioncube_to_live.bat'
```

Eine Vorschau ohne Dateiänderungen ist möglich mit:

```powershell
& 'D:\Entwicklung\ioncube_fewo_oct\copy_ioncube_to_live.bat' --dry-run
```

Die Batch-Datei verwendet Robocopy mit `/E /IS /IT`, um Unterverzeichnisse einschließlich leerer Ordner zu übernehmen und auch gleich eingestufte Dateien erneut zu kopieren. Sie beendet sich bei Robocopy-Fehlercodes ab 8 mit einem Fehlerstatus. Quelle und Ziel werden relativ zum Speicherort der Batch-Datei ermittelt und müssen vorhanden sein. Dieser Schritt aktualisiert das lokale Live-Projekt; ein Upload wird damit nicht ausgeführt.

## 4. Update committen, taggen und pushen

Nach dem Kopieren wird das Git-Projekt `D:\Entwicklung\ioncube_fewo_oct\ioncube\october-webmodul-live` auf `master` veröffentlicht. Dafür ist `D:\Entwicklung\ioncube_fewo_oct\release_webmodul.bat` angelegt; diese Startdatei ruft das danebenliegende PowerShell-Skript `release_webmodul.ps1` auf.

Vor dem Start muss im Live-Projekt `master` ausgecheckt sein. Alle dort vorhandenen Änderungen müssen zum Update gehören, da das Skript sie vollständig in den Commit aufnimmt. Schritt 2 und Schritt 3 müssen erfolgreich abgeschlossen sein.

`release_webmodul.bat` per Doppelklick starten. Das Skript führt diese Schritte automatisch aus:

1. Git-Projekt und Branch `master` prüfen.
2. Die höchste Versionsnummer im Format `X.Y.Z` aus `updates\version.yaml` des Live-Projekts lesen.
3. Prüfen, dass diese Version höher ist als sämtliche erkannten Versionstags lokal und auf `origin`.
4. Mit `git add --all` sämtliche Änderungen einschließlich neuer Dateien und Löschungen vormerken.
5. Den Commit mit der Nachricht `update <Versionsnummer>` erstellen, beispielsweise `update 3.11.0`.
6. Direkt auf diesem neu erstellten Commit den Tag `v<Versionsnummer>` anlegen, beispielsweise `v3.11.0`. Das kleine `v` entspricht den bestehenden Tags des Projekts.
7. Erst nach dem erfolgreichen Anlegen des Tags `master` und genau diesen Tag gemeinsam mit `git push --atomic` nach `origin` pushen. Der Server übernimmt beide Referenzen zusammen oder keine davon; andere lokale Tags werden nicht mitgepusht.

Eine Vorschau ohne Vormerken, Commit, Tag oder Push ist in PowerShell möglich:

```powershell
& 'D:\Entwicklung\ioncube_fewo_oct\release_webmodul.ps1' -DryRun
```

Die Vorschau prüft auch vorhandene Versionstags und liest dafür bei Bedarf die Tags von `origin`. Das Skript bricht bei einem falschen Branch, Merge-Konflikten, fehlenden Änderungen, einem bestehenden Versionstag oder Git-Fehlern ab. Bestehende Tags werden nicht überschrieben; ein Force-Push wird nicht verwendet. Der Server muss atomare Pushes unterstützen.

Falls ein Push fehlschlägt, bleiben der lokale Commit und Tag erhalten. Nach Behebung der Ursache zunächst prüfen, dass der Tag auf den gewünschten Commit zeigt und `master` weiterhin diesen Stand hat. Anschließend nur den Push wiederholen, beispielsweise für `3.11.0`:

```powershell
git -C 'D:\Entwicklung\ioncube_fewo_oct\ioncube\october-webmodul-live' push --atomic origin refs/heads/master:refs/heads/master refs/tags/v3.11.0:refs/tags/v3.11.0
```

**Stand vom 27.10.2026:** Der Tag `v3.11.0` existiert bereits lokal. Das Skript veröffentlicht dieselbe Version daher nicht erneut. Der automatisierte Ablauf wurde mit einem temporären lokalen Repository und einem lokalen Git-Ziel geprüft, einschließlich neuer Dateien, Commit-Nachricht, Tag-Zuordnung, gemeinsamem Push und Abbruch bei bestehenden Tags oder falschem Branch. Im eigentlichen Live-Projekt wurde dabei kein Commit, Tag oder Push ausgeführt.
