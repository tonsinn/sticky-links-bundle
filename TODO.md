# TODO

Erledigte Punkte stehen im Archiv am Ende von CHANGELOG.md.

## Offen

1. **Metadaten-PR abwarten:** https://github.com/contao/package-metadata/pull/865 (Titel, Beschreibung, Logo für
   den Contao Manager). Stand 2026-11-13: offen, Lint grün, wartet auf Review. Nach dem Merge erscheint das Bundle
   im Manager innerhalb von etwa 30 Minuten als „Sticky-Links“; dann prüfen und den lokalen Branch aufräumen.
2. **RockSolid-Pfad mit echter Schrift testen:** bisher nur mit selbst erzeugter Test-Schrift geprüft (Auswahlmenü
   und Icon-Picker v2.1.3 laufen in Contao 5.7 und 6.0). Offen: Fontdateien eines lizenzierten Tao/Oneo.
3. **Optional: Test auf dem Remote-Server** (KeyHelp, PHP 8.5) über `bin/remote-install.sh`; dafür `testinstall.env`
   anlegen und in `~/KI-Projekte/notebook-sync/secrets-list.txt` eintragen. Lokal ist Contao 6 bereits getestet.
4. **Syncthing am Notebook abschließen:** Freigabe `Sticky-Links` annehmen — **Pfadfeld prüfen:
   `/home/tonsinn/Sticky-Links`** —, `.stignore` dort gleich setzen, `completion: 100` abwarten, erst dann Claude
   dort starten.
5. **Später:** Leiste erst ab Scrolltiefe einblenden; Panel-Inhalt alternativ aus direkt verschachtelten
   Inhaltselementen; PHPUnit-Tests für die Icon-Provider; `docs/` mit Screenshots.
6. **Aufräumen nach dem Release:** `sticky-links-bundle-0.9.0.zip` im Projektordner löschen;
   `composer.json.bak-stickylinks` / `composer.lock.bak-stickylinks` in `~/contao57` löschen; entscheiden, ob
   `~/contao60` bleibt (hat keinen Backend-Benutzer: `ddev exec php vendor/bin/contao-console contao:user:create`).
7. **Artikelauswahl im Panel:** zeigt allen Redakteuren alle Artikel, unabhängig von ihren Seitenrechten — bei Bedarf
   auf die Seitenrechte des Benutzers einschränken.
