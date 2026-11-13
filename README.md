# Sticky-Links für Contao

[English version](README.en.md)

Eine Symbolleiste, die fest am linken oder rechten Rand des Browserfensters steht. Jedes Symbol ist entweder ein
**Link**, dessen Text beim Überfahren herausfährt, oder öffnet ein **Panel** mit einem Contao-Artikel – zum Beispiel
für Telefonnummer, Kontaktformular, Suche oder Öffnungszeiten.

- Contao 5.3+ und 6, PHP 8.2+
- Symbole aus **Font Awesome Free** (wird mitinstalliert) oder aus der **RockSolid-Icon-Schrift** der Themes
  Tao und Oneo
- per Tastatur und Touch bedienbar, reine Twig-Templates, kein jQuery

## Installation

Im Contao Manager nach `tonsinn/sticky-links-bundle` suchen oder per Composer:

```bash
composer require tonsinn/sticky-links-bundle
```

Danach die Datenbank aktualisieren (Contao Manager oder `vendor/bin/contao-console contao:migrate`).

## Einrichtung

1. In einem Artikel ein Inhaltselement **Sticky-Links** anlegen. Hier wird für alle Symbole gemeinsam eingestellt:

   | Einstellung | Auswahl | Standard |
   |---|---|---|
   | Rand | links, rechts | links |
   | Vertikale Position | oben, mittig, unten | mittig |
   | Abstand oben/unten | Wert mit Einheit (px, rem, vh, %) | 5rem |
   | Symbolgröße | klein, mittel, groß | mittel |
   | Auf kleinen Bildschirmen | kleine Symbole am Rand, waagerechte Leiste unten, ausblenden | kleine Symbole am Rand |
   | Symbolfarbe | Farbwähler | Akzentfarbe |
   | Hintergrundfarbe | Farbwähler | Weiß (`#ffffff`) |

2. Innerhalb der Leiste je Symbol ein Element **Sticky-Link-Symbol** anlegen:

   | Einstellung | Bedeutung |
   |---|---|
   | Text | Link: herausfahrender Text. Panel: Titel. Zugleich der Name für Screenreader. |
   | Verhalten | **Link** (Seite, URL, `tel:`, `mailto:`; optional in neuem Fenster) oder **Panel mit Artikel** |
   | Symbolsatz / Symbol | Font Awesome Free oder RockSolid-Icons |
   | Symbolfarbe, Hintergrundfarbe | leer = Farbe der Leiste |

3. Soll die Leiste **auf allen Seiten** erscheinen: ein Frontend-Modul **Sticky-Links** anlegen, darin die Leiste
   auswählen und das Modul im Seitenlayout einbinden. Der Artikel mit der Leiste kann dafür in einer versteckten
   Seite liegen.

Artikel für Panels legt man am besten ebenfalls in einer versteckten Seite ab. Der Panel-Inhalt wird vom Suchindex
ausgenommen, damit er nicht für jede Seite gefunden wird.

## Symbole

### Font Awesome Free

Das Paket `fortawesome/font-awesome` wird als Abhängigkeit installiert. Die Symbole werden als Inline-SVG ausgegeben;
es wird weder eine Schrift noch ein Stylesheet von Font Awesome geladen. Im Backend lässt sich das Symbol über seinen
englischen Namen suchen (`phone`, `envelope`, `location-dot` …), Übersicht:
<https://fontawesome.com/search?ic=free>.

Font Awesome Free steht unter CC BY 4.0 (Icons), SIL OFL 1.1 (Schriften) und MIT (Code). Der Lizenzhinweis bleibt im
ausgegebenen SVG erhalten.

### RockSolid-Icons (Tao, Oneo)

Ist eines der Themes installiert, erscheint im Feld „Symbolsatz“ zusätzlich **RockSolid-Icons**. Die Schrift wird
nicht mitgeliefert, sondern aus der Installation gelesen:

- `files/tao/fonts/rocksolid-icons.svg`
- `files/oneo/fonts/rocksolid-icons.svg`

Auch selbst ergänzte Glyphen stehen zur Auswahl, weil die Liste direkt aus der Schriftdatei stammt. Liegt die Schrift
an einem anderen Ort, kann der Pfad in `config/config.yaml` gesetzt werden:

```yaml
tonsinn_sticky_links:
    rocksolid_font: 'files/mein-theme/fonts/rocksolid-icons.svg'
```

Neben der `.svg`-Datei muss eine gleichnamige `.woff2`-, `.woff`- oder `.ttf`-Datei liegen.

Ist die Erweiterung `madeyourday/contao-rocksolid-icon-picker` installiert, erscheint im Backend deren visuelle
Symbolauswahl; ohne sie ein Auswahlmenü mit Namen und Codepoints.

## Aussehen anpassen

Alle Maße und Farben sind CSS-Custom-Properties und lassen sich im eigenen Stylesheet überschreiben:

```css
.stickylinks {
    --stickylinks-accent: #c4161c;    /* Symbolfarbe, wenn im Backend keine gewählt ist */
    --stickylinks-size: 3.25rem;      /* Kantenlänge eines Symbols */
    --stickylinks-gap: 0px;           /* Abstand zwischen den Symbolen */
    --stickylinks-radius: 0px;        /* Eckenradius */
    --stickylinks-panel-width: 24rem; /* Breite des Panels */
    --stickylinks-z: 900;             /* Stapelreihenfolge */
}
```

Die Templates `content_element/sticky_links`, `content_element/sticky_links_item` und
`frontend_module/sticky_links` können wie gewohnt überschrieben werden.

## Bedienung und Barrierefreiheit

- Links sind echte `<a>`-Elemente, Panels werden über `<button aria-expanded>` geöffnet.
- Panels öffnen per Klick, Enter oder Leertaste, auf Geräten mit Maus zusätzlich beim Überfahren. Ein Klick hält ein
  per Maus geöffnetes Panel offen.
- Schließen: Escape, Schließen-Schaltfläche, Klick außerhalb.
- `prefers-reduced-motion` wird beachtet; im Druck ist die Leiste ausgeblendet.

## Lizenz

LGPL-3.0-or-later – © Mathias Ebert, [tonsinn.de](https://tonsinn.de)
