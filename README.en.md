# Sticky Links for Contao

[Deutsche Version](README.md)

A bar of icons fixed to the left or right edge of the browser window. Each icon is either a **link** whose text slides
out on hover, or opens a **panel** showing a Contao article – for a phone number, a contact form, the search or
opening hours, for example.

- Contao 5.3+ and 6, PHP 8.2+
- Icons from **Font Awesome Free** (installed along with the bundle) or from the **RockSolid icon font** of the Tao
  and Oneo themes
- Keyboard and touch accessible, Twig templates only, no jQuery

## Installation

Search for `tonsinn/sticky-links-bundle` in the Contao Manager, or use Composer:

```bash
composer require tonsinn/sticky-links-bundle
```

Then update the database (Contao Manager or `vendor/bin/contao-console contao:migrate`).

## Setup

1. Add a **Sticky links** content element to an article. It holds the settings shared by all icons:

   | Setting | Choices | Default |
   |---|---|---|
   | Edge | left, right | left |
   | Vertical position | top, centred, bottom | centred |
   | Distance from top/bottom | value with unit (px, rem, vh, %) | 5rem |
   | Icon size | small, medium, large | medium |
   | On small screens | small icons at the edge, horizontal bar at the bottom, hide | small icons at the edge |
   | Icon colour | colour picker | accent colour |
   | Background colour | colour picker | white (`#ffffff`) |

2. Inside the bar, add one **Sticky link icon** element per icon:

   | Setting | Meaning |
   |---|---|
   | Text | Link: the slide-out text. Panel: the title. Also the name announced by screen readers. |
   | Behaviour | **Link** (page, URL, `tel:`, `mailto:`; optionally in a new window) or **Panel with article** |
   | Icon set / icon | Font Awesome Free or RockSolid icons |
   | Icon colour, background colour | empty = colour of the bar |

3. To show the bar **on every page**, create a **Sticky links** front end module, select the bar in it and add the
   module to the page layout. The article holding the bar can live in a hidden page.

Articles shown in panels are best kept in a hidden page as well. Panel content is excluded from the search index, so
it is not found once for every page.

## Icons

### Font Awesome Free

The package `fortawesome/font-awesome` is installed as a dependency. Icons are printed as inline SVG; neither a font
nor a stylesheet of Font Awesome is loaded. In the back end, search for the icon by its name (`phone`, `envelope`,
`location-dot` …); overview: <https://fontawesome.com/search?ic=free>.

Font Awesome Free is licensed under CC BY 4.0 (icons), SIL OFL 1.1 (fonts) and MIT (code). The licence notice is kept
in the SVG output.

### RockSolid icons (Tao, Oneo)

If one of the themes is installed, the "Icon set" field additionally offers **RockSolid icons**. The font is not
shipped with the bundle but read from the installation:

- `files/tao/fonts/rocksolid-icons.svg`
- `files/oneo/fonts/rocksolid-icons.svg`

Glyphs you added yourself are available too, as the list is read from the font file. If the font is stored somewhere
else, set the path in `config/config.yaml`:

```yaml
tonsinn_sticky_links:
    rocksolid_font: 'files/my-theme/fonts/rocksolid-icons.svg'
```

A `.woff2`, `.woff` or `.ttf` file of the same name has to be stored next to the `.svg` file.

With the extension `madeyourday/contao-rocksolid-icon-picker` installed, the back end shows its visual icon picker;
without it, a select menu listing names and code points.

## Styling

All dimensions and colours are CSS custom properties that can be overridden in your own stylesheet:

```css
.stickylinks {
    --stickylinks-accent: #c4161c;    /* icon colour if none is chosen in the back end */
    --stickylinks-size: 3.25rem;      /* edge length of an icon */
    --stickylinks-gap: 0px;           /* gap between the icons */
    --stickylinks-radius: 0px;        /* corner radius */
    --stickylinks-panel-width: 24rem; /* width of the panel */
    --stickylinks-z: 900;             /* stacking order */
}
```

The templates `content_element/sticky_links`, `content_element/sticky_links_item` and
`frontend_module/sticky_links` can be overridden as usual.

## Usage and accessibility

- Links are real `<a>` elements; panels are opened by a `<button aria-expanded>`.
- Panels open on click, Enter or Space, and additionally on hover on devices with a mouse. A click keeps a panel
  opened by hover open.
- Closing: Escape, the close button, or a click outside.
- `prefers-reduced-motion` is respected; the bar is hidden when printing.

## Licence

LGPL-3.0-or-later – © Mathias Ebert, [tonsinn.de](https://tonsinn.de)
