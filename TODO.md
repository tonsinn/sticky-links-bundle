# TODO

Erledigte Punkte stehen im Archiv am Ende von CHANGELOG.md.

## Offen

1. **Packagist:** Paket unter https://packagist.org/packages/submit mit der Repo-URL eintragen (macht Mathias, braucht
   den Packagist-Login); prüfen, dass der GitHub-Hook `packagist.org/api/github` angelegt wurde. Danach in W246 das
   hochgeladene ZIP 0.9.0 im Contao Manager löschen und auf `^1.0` von Packagist umstellen.
2. **RockSolid-Pfad mit echter Schrift testen:** bisher nur mit selbst erzeugter Test-Schrift geprüft (Auswahlmenü
   und Icon-Picker v2.1.3 laufen in Contao 5.7 und 6.0). Offen: Fontdateien eines lizenzierten Tao/Oneo.
3. **Optional: Test auf dem Remote-Server** (KeyHelp, PHP 8.5) über `bin/remote-install.sh`; dafür `testinstall.env`
   anlegen und in `~/KI-Projekte/notebook-sync/secrets-list.txt` eintragen. Lokal ist Contao 6 bereits getestet.
4. **Metadaten-PR in `contao/package-metadata`** (`meta/tonsinn/sticky-links-bundle/{de,en}.yml`, `logo.svg`;
   Vorbild: `img-navi`). Das aktuelle Logo (800×800, gefüllt) weicht vom Stil der anderen tonsinn-Logos ab
   (Strichgrafik `#91979c`, 360×360) — vorher klären.
6. **Syncthing am Notebook abschließen:** Freigabe `Sticky-Links` annehmen — **Pfadfeld prüfen:
   `/home/tonsinn/Sticky-Links`** —, `.stignore` dort gleich setzen, `completion: 100` abwarten, erst dann Claude
   dort starten.
7. **Später:** Leiste erst ab Scrolltiefe einblenden; Panel-Inhalt alternativ aus direkt verschachtelten
   Inhaltselementen; PHPUnit-Tests für die Icon-Provider; `docs/` mit Screenshots.
