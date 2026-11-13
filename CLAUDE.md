# Sticky-Links — Contao Bundle

## Projekt-Überblick
Eigenes Contao-Bundle von **tonsinn**, entwickelt **parallel zu `belegungsplan-bundle`** (gleiche Struktur, gleiche
Konventionen, gleiche Veröffentlichungswege). Name: *Sticky-Links*.

## Funktionsumfang (festgelegt 2026-11-13)
Symbolleiste, fest am linken/rechten Browserrand (`position: fixed`).
- **Inhaltselement `sticky_links`** (Leiste, `nestedFragments`): Rand, vertikale Position, Abstand, Symbolgröße,
  Mobil-Modus (Rand/untere Leiste/ausblenden), Standardfarben.
- **Inhaltselement `sticky_links_item`** (Symbol): Text, Typ **Link** (`url`, `target`) oder **Panel mit Artikel**
  (`stickyLinksArticle`, Ausgabe über `{{insert_article::ID}}`), Symbolsatz + Symbol, eigene Farben (leer = Leiste).
- **Frontend-Modul `sticky_links`**: gibt eine gewählte Leiste über das Seitenlayout auf allen Seiten aus.
- **Icons:** Font Awesome Free (`fortawesome/font-awesome` als `require`, Ausgabe als Inline-SVG) und
  RockSolid-Icon-Font aus Tao/Oneo (nur aus `files/` gelesen, nie ausgeliefert; optionaler Icon-Picker von
  madeyourday, sonst Select). Klassen: `src/Icon/*Provider.php`.
- Backend-Callbacks gesammelt in `src/EventListener/DataContainer/StickyLinksListener.php`.
- Die Vorlage-Website wird in veröffentlichten Texten (README, Metadaten, Commits) **nicht** genannt.

## Paket-Identität
- **Packagist**: `tonsinn/sticky-links-bundle`
- **PHP-Namespace**: `Tonsinn\StickyLinksBundle`
- **Bundle-Klasse**: `TonsinnStickyLinksBundle`
- **Lizenz**: LGPL-3.0-or-later, Autor Mathias Ebert (`https://tonsinn.de`) — wie `belegungsplan-bundle`
- **Contao-Kompatibilität (Ziel)**: Contao 5.3+ und 6.x, PHP ^8.2 — wie `belegungsplan-bundle` / `img-navi`

## Vorbilder im Haus
| Zweck | Vorbild |
|---|---|
| `composer.json`, `.gitignore`, `.gitattributes`, LICENSE, Release-Workflow (Tag → Packagist), Doku | `/home/tonsinn/belegungsplan-bundle/` |
| Bundle-Struktur mit `getPath()`-Override, `bin/`-Skripte (rsync-Deploy), `HINWEISE.md`, `testinstall.env.example` | `/home/tonsinn/img-navi/` |
| Packagist-/Metadaten-Veröffentlichung | `/home/tonsinn/package-metadata/` |

Vor dem Anlegen neuer Dateien erst dort nachsehen und die Konvention übernehmen, statt sie neu zu erfinden.

## Test-Umgebungen
- Lokal: DDEV-Instanz `~/contao57` (Contao 5.7) — gemeinsam genutzt mit `belegungsplan-bundle` und `img-navi`;
  Bundle-Sync-Skript analog `bin/sync-*.sh` anlegen.
- Remote: Zugangsdaten nur in `testinstall.env` (steht in `.gitignore`, Vorlage: `testinstall.env.example`).
  Auf dem KeyHelp-Server PHP immer über `keyhelp-php85` aufrufen (siehe `img-navi/HINWEISE.md`).

## Status
Stand 2026-11-13: Bundle vollständig implementiert (Version 1.0.0 vorbereitet), lokales Git-Repo auf `main`.
**Noch nicht in Contao getestet** (Docker/DDEV lief nicht) und **nicht veröffentlicht** (kein GitHub-Repo, kein Push,
kein Tag) — nächste Schritte siehe `TODO.md`.

---

Release-Historie: siehe CHANGELOG.md.
Offene Punkte: siehe TODO.md.
Dauerhafte Invarianten: siehe HINWEISE.md.
