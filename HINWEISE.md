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

Details und Begründungen: `/home/tonsinn/belegungsplan-bundle/CLAUDE.md` und `/home/tonsinn/img-navi/HINWEISE.md`.
