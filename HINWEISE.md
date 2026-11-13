# HINWEISE — dauerhafte Betriebs-Invarianten

Dauerhafte Regeln, die bei Änderungen am Bundle gelten. Neue Erkenntnisse hier sammeln (nicht in `CLAUDE.md`).

## Aus den Schwesterprojekten übernommen (bei Bedarf prüfen/anpassen)

- Zugangsdaten nur in `testinstall.env` (in `.gitignore`), nie in Git, nie im Chat ausgeben. Vorlage:
  `testinstall.env.example`.
- Auf dem KeyHelp-Testserver PHP/Composer immer über `keyhelp-php85` aufrufen.
- Contao 6: keine Input-Encoding mehr — Werte roh speichern, bei der Ausgabe escapen; jede DCA braucht einen
  `label`-Block; keine `.html5`-Templates.
- Bei DCA-Änderungen: erst `cache:clear`, dann `contao:migrate`.
- Shell-Skripte brauchen LF-Zeilenenden (`.gitattributes`: `*.sh text eol=lf`).
- Syncthing-Aufnahme erst nach Klärung der Ignore-Liste; SSH-Schlüssel nie syncen.

## Sticky-Links-spezifisch

- **RockSolid-Schriftdateien nie ins Repo oder Paket aufnehmen** (kommerziell). Sie werden nur aus `files/` der
  Installation gelesen; die Glyphenliste kommt zur Laufzeit aus der `.svg`-Fontdatei.
- Font-Awesome-Icons werden als Inline-SVG aus `vendor/fortawesome/font-awesome/svgs/` gelesen; der Lizenzkommentar
  im SVG bleibt erhalten (CC BY 4.0 verlangt Namensnennung).
- Die Leiste (`.stickylinks`) darf **kein `transform`** bekommen: Sie spannt die volle Fensterhöhe auf
  (`pointer-events: none`), das Panel ist mobil `position: fixed` und würde sich sonst an der Leiste statt am
  Viewport ausrichten. `.stickylinks__item` bleibt `position: static`, weil das Panel sich an der Leiste ausrichtet.
- `stickyLinksColor`/`stickyLinksBackground` werden von Leiste **und** Symbol benutzt (leer = erben).
- Asset-Pfad `bundles/tonsinnstickylinks/` hängt am Namen der Bundle-Klasse; `contao/templates/.twig-root` ist
  Pflicht.
- Die Vorlage-Website wird in veröffentlichten Texten nicht genannt.
- Vor dem ersten Push: `git grep -I -l -F -- "<wert>" $(git rev-list --all)` für alle Werte aus `testinstall.env`.

- Hilfetexte im Backend kurz halten (etwa 80 Zeichen): Contao 5.7 schneidet längere Texte mit „…“ ab.
- Browser-Tests gegen DDEV: Der Headless-Browser lehnt das DDEV-Zertifikat ab und Contao leitet wegen `useSSL` auf
  HTTPS um — Chromium mit `--ignore-certificate-errors` starten und per CDP verbinden.
- `files/<theme>/` muss öffentlich sein (`.public` + `contao:symlinks`), sonst lädt die RockSolid-Schrift nicht.

## Veröffentlichung und Metadaten

- **Metadaten-Linter lokal nur im Container prüfen** (aspell fehlt auf dem Host): in `~/package-metadata`
  `docker run --rm -v "$PWD":/src:ro php:8.3-cli bash -c '…'` mit `apt-get install aspell aspell-en aspell-de
  aspell-cs aspell-es aspell-fr git unzip`, Composer installieren, Repo nach `/work` kopieren,
  `cd linter && composer install`, dann `php linter/lint meta/tonsinn/<paket>/*.yml`. `linter/vendor` nie im
  Arbeitsverzeichnis anlegen — es ist nicht in `.gitignore`.
- Die Rechtschreibprüfung (nur `title` und `description`) lehnt deutsche Komposita ab („Symbolleiste“,
  „Kontaktformular“, „Browserfensters“). Lieber umformulieren; Eigennamen (z. B. „Tao“, „Oneo“) alphabetisch in
  `linter/allowlists/default.txt` eintragen.
- **Logo:** transparent, ohne Hintergrundfläche (dunkles Manager-Design); `public/sticky-links.svg` und das
  `logo.svg` im Metadaten-Repo müssen identisch sein.
- **Vorab-Test ohne Packagist:** ZIP aus `git archive HEAD` (beachtet `export-ignore`), in dessen `composer.json`
  eine Vorab-Version (`0.9.x`, nie die spätere Release-Nummer) eintragen, im Contao Manager über „Pakete hochladen“
  installieren. Vor dem Umstieg auf Packagist das ZIP im Manager löschen; dabei angebotene Löschungen von
  `stickyLinks…`-Spalten nicht bestätigen.
- Das installierte `gh` kennt `--accept-visibility-change-consequences` nicht; Sichtbarkeit über
  `gh api -X PATCH repos/<owner>/<repo> -f visibility=public` ändern. Direkt danach kann ein SSH-Push einmal
  fehlschlagen — wiederholen.
- Die Erstanmeldung eines Pakets bei Packagist macht Mathias selbst (Login nötig); der GitHub-Hook wird dabei
  automatisch angelegt.

Details und Begründungen: `/home/tonsinn/belegungsplan-bundle/CLAUDE.md` und `/home/tonsinn/img-navi/HINWEISE.md`.
