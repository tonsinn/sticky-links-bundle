# TODO

Erledigte Punkte stehen im Archiv am Ende von CHANGELOG.md.

## Offen

1. **Erster Test in Contao 5.7 (DDEV `~/contao57`)** — Docker Desktop starten, dann:
   - in `~/contao57/composer.json` Path-Repository `./sticky-links-bundle` (`symlink: true`, `versions`:
     `dev-main`) eintragen, `bin/sync-sticky-links.sh` einmal laufen lassen (legt die Kopie an), dann
     `ddev composer require tonsinn/sticky-links-bundle:@dev`, danach `bin/sync-sticky-links.sh --migrate`;
   - Spalten `stickyLinks…` in `tl_content`/`tl_module` prüfen; `lint:twig` läuft im Sync-Skript;
   - Backend: Leiste + Symbole (Link mit FA-Icon, `tel:`-Link, Panel mit Artikel), Modul im Layout;
   - Frontend: links/rechts × oben/mittig/unten, Farben/Defaults, Label, Panel per Klick/Tastatur/Escape/Hover,
     drei Mobil-Modi, Suchindex ohne Panel-Inhalt, CSP-Nonce am `<style>` des RockSolid-Fonts.
2. **RockSolid-Pfad testen:** Fontdateien eines lizenzierten Tao/Oneo (`rocksolid-icons.svg` + `.woff2`) nach
   `files/tao/fonts/` der Testinstanz; mit und ohne `madeyourday/contao-rocksolid-icon-picker`. Prüfen, ob der Picker
   im Contao-6-Backend läuft (sein JS setzt MooTools voraus) — sonst Select-Fallback erzwingen.
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
