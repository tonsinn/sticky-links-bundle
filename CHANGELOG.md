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

## Archiv (erledigte TODO-Punkte)

- Anforderungen geklärt, Paket-Identität bestätigt, Bundle-Gerüst angelegt (2026-11-13).
