# CHANGELOG

### v1.0.0 (unveröffentlicht)

#### Neu
- Inhaltselemente „Sticky-Links“ (Leiste) und „Sticky-Link-Symbol“ (Link oder Panel mit Artikel).
- Frontend-Modul „Sticky-Links“ für die seitenweite Ausgabe über das Seitenlayout.
- Symbole aus Font Awesome Free (Inline-SVG) und aus der RockSolid-Icon-Schrift der Themes Tao und Oneo.
- Position links/rechts und oben/mittig/unten, Symbolgröße, Farben, drei Varianten für kleine Bildschirme.

## Claude-Code-Session-Historie

## 2026-11-13 — Teil 1: Projekt angelegt

- Projektverzeichnis `/home/tonsinn/Sticky-Links/` aus der Session in `KI-Projekte` angelegt: Contao-Bundle von tonsinn,
  parallel zu `belegungsplan-bundle`.
- Gerüst: `CLAUDE.md`, `TODO.md`, `CHANGELOG.md`, `HINWEISE.md`, `.gitignore`, `.stignore`,
  `.claude/settings.local.json` (`autoMemoryDirectory` → `~/Obsidian/Claude-Memory/Sticky-Links`).
- In `KI-Projekte/projekte.md` als Nr. 14 eingetragen.
- Bewusst offen: Funktionsumfang, Paket-Identität, Git, Syncthing-Aufnahme.

## 2026-11-13 — Teil 2: Syncthing-Aufnahme (Desktop)

- Syncthing-Ordner `Sticky-Links` per REST am Desktop angelegt (`/home/tonsinn/Sticky-Links`, `sendreceive`,
  `ignorePerms`, `fsWatcherEnabled`, `rescanIntervalS=60`, geteilt mit Notebook `CE4P4LZ…`). `.stignore` lag vorher vor
  (`vendor`, `composer.lock`, `node_modules`, `*Zone.Identifier`, `.DS_Store`). Status: `idle`, 0 Fehler, 6 Dateien.
- Das Notebook war zum Zeitpunkt offline (`completion: 0`); Freigabe dort noch nicht angenommen — siehe TODO 5.

## 2026-11-13 — Teil 3: Anforderungen geklärt, Bundle implementiert

- Anforderungen geprüft und mit Rückfragen festgelegt: Typ je Symbol (Link/Panel), Element + Modul, Mobil-Modus
  einstellbar, Icons aus RockSolid-Font und Font Awesome Free. Korrekturen an der Vorgabe: Hintergrund-Default
  `#ffffff` (statt `#fffff`); „Akzentfarbe“ als CSS-Variable `--stickylinks-accent`, da das Bundle die Theme-Farbe
  nicht kennt; Hover allein reicht nicht (Touch/Tastatur) → Button mit `aria-expanded`.
- Vollständiges Bundle nach Vorbild `img-navi` angelegt (siehe `CLAUDE.md`), lokales Git-Repo, erster Commit.
- Geprüft: `php -l`, XLIFF wohlgeformt, `composer validate`, Icon-Provider gegen `fortawesome/font-awesome` 7.3.1
  (2.883 Icons) und einen Test-SVG-Font. **Nicht geprüft:** Lauf in Contao (Docker Desktop war aus).

## 2026-11-13 — Teil 4: Test in Contao 5.7.13 (DDEV `~/contao57`)

- Bundle als Path-Repository `./sticky-links-bundle` eingebunden (`repositories.stickylinks`), Migration legte 14
  Spalten an; als Nebeneffekt lief die bis dahin ausstehende Core-Migration `PrepareForOutputEncodingMigration`.
  Sicherungen: `composer.json.bak-stickylinks`, `composer.lock.bak-stickylinks` in `~/contao57`.
- Testdaten per SQL: Seite 900 „Sticky-Inhalte“, Artikel 900/901, Leiste 900 mit Symbolen 901–903, Modul 900 im
  Layout 1.
- Frontend (Playwright gegen Headless-Chromium): alle sechs Positionen, Farben/Defaults, Label bei Hover, Panel per
  Klick/Tastatur/Escape/Außenklick/Hover, drei Mobil-Modi, kein Panel-Inhalt im Suchindex, keine JS-Fehler.
- Backend: Formulare von Leiste, Symbol (Link/Panel) und Modul, Unterpaletten, Speichern, Vorschau in der Liste.
- RockSolid mit selbst erzeugter Test-Schrift: Auswahlmenü und Icon-Picker v2.1.3 (auswählen, speichern), Schrift
  lädt im Frontend. Picker, Test-Schrift und temporärer Admin danach wieder entfernt.
- Nachgebessert: Hilfetexte gekürzt (das Backend schneidet lange Texte ab).
- Hinweis: Der Headless-Browser meldet `(hover: hover)` nicht; die Hover-Logik wurde mit überschriebenem
  `matchMedia` geprüft.

## 2026-11-13 — Teil 5: GitHub-Repo (privat) und Test in Contao 6.0.6

- Privates Repo `tonsinn/sticky-links-bundle` angelegt, `main` gepusht, CI grün. Neues Logo von Mathias committet.
- Neue lokale DDEV-Instanz **`~/contao60`** (Contao 6.0.6, PHP 8.4, MariaDB 11.8, `https://contao60.ddev.site`),
  Konfiguration von `contao57` übernommen. Bundle als Path-Repository installiert, Testdaten wie in `contao57`.
  Die Instanz hat **keinen Backend-Benutzer** (Test-Admin wieder gelöscht).
- Gleiche Tests wie in 5.7 bestanden: Frontend (Positionen, Hover, Panel, Mobil), Backend (Formulare, Speichern),
  Suchindex, RockSolid mit Test-Schrift inkl. Icon-Picker v2.1.3 (MooTools ist im Contao-6-Backend vorhanden).
- Zusätzlich geprüft: Text mit `<b>`, `&` und Anführungszeichen wird roh gespeichert und maskiert ausgegeben.

## Archiv (erledigte TODO-Punkte)

- Anforderungen geklärt, Paket-Identität bestätigt, Bundle-Gerüst angelegt (2026-11-13).
- Erster Test in Contao 5.7 (DDEV) bestanden (2026-11-13).
- Privates GitHub-Repo angelegt und gepusht; Test in Contao 6.0.6 (DDEV `~/contao60`) bestanden (2026-11-13).
