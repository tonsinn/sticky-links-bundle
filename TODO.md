# TODO

Erledigte Punkte stehen im Archiv am Ende von CHANGELOG.md.

## Offen

1. **Sichttest durch Mathias** in `https://contao57.ddev.site` (Testdaten liegen bereit: Seite „Sticky-Inhalte“,
   Leiste ID 900 mit drei Symbolen, Modul „Sticky-Links“ im Layout „Standard“). Optik, Farben und Abstände beurteilen.
2. **RockSolid-Pfad mit echter Schrift testen:** bisher nur mit selbst erzeugter Test-Schrift geprüft (Auswahlmenü
   und Icon-Picker v2.1.3 laufen in Contao 5.7). Offen: Fontdateien eines lizenzierten Tao/Oneo und der Picker im
   **Contao-6**-Backend (sein JS setzt MooTools voraus) — sonst Select-Fallback erzwingen.
3. **Test auf Contao 6.0** (Remote-Testserver, `bin/remote-install.sh`; `testinstall.env` anlegen und in
   `~/KI-Projekte/notebook-sync/secrets-list.txt` eintragen).
4. **Git/GitHub:** Repo `tonsinn/sticky-links-bundle` anlegen und pushen — **erst nach ausdrücklicher Freigabe**;
   vorher Historie auf Zugangsdaten prüfen (siehe `HINWEISE.md`).
5. **Veröffentlichung:** Tag `v1.0.0`, Packagist-Eintrag + Hook, Metadaten-PR in `contao/package-metadata`
   (`meta/tonsinn/sticky-links-bundle/{de,en}.yml`, `logo.svg` = `public/sticky-links.svg`; Vorbild: `img-navi`).
6. **Syncthing am Notebook abschließen:** Freigabe `Sticky-Links` annehmen — **Pfadfeld prüfen:
   `/home/tonsinn/Sticky-Links`** —, `.stignore` dort gleich setzen, `completion: 100` abwarten, erst dann Claude
   dort starten.
7. **Später:** Leiste erst ab Scrolltiefe einblenden; Panel-Inhalt alternativ aus direkt verschachtelten
   Inhaltselementen; PHPUnit-Tests für die Icon-Provider; `docs/` mit Screenshots.
