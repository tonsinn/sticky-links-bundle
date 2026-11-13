<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

namespace Tonsinn\StickyLinksBundle\Icon;

use Composer\InstalledVersions;

/**
 * Provides the icons of Font Awesome Free, which is installed as a Composer
 * dependency of this bundle. The icons are printed as inline SVG, so neither a
 * web font nor an additional request is needed and the icon takes on the text
 * colour of its container.
 */
class FontAwesomeIconProvider
{
    public const PACKAGE = 'fortawesome/font-awesome';

    public const STYLES = ['solid', 'regular', 'brands'];

    private string|false|null $svgDir = null;

    /**
     * @var array<string, array<string, string>>|null
     */
    private array|null $icons = null;

    public function isAvailable(): bool
    {
        return null !== $this->getSvgDir();
    }

    /**
     * All icons grouped by style, as "style => [style/name => name]".
     *
     * @return array<string, array<string, string>>
     */
    public function getIcons(): array
    {
        if (null !== $this->icons) {
            return $this->icons;
        }

        $this->icons = [];
        $svgDir = $this->getSvgDir();

        if (null === $svgDir) {
            return $this->icons;
        }

        foreach (self::STYLES as $style) {
            $files = glob($svgDir.'/'.$style.'/*.svg') ?: [];
            sort($files);

            foreach ($files as $file) {
                $name = basename($file, '.svg');
                $this->icons[$style][$style.'/'.$name] = $name;
            }
        }

        return $this->icons;
    }

    /**
     * Returns the value unchanged if it names an existing icon ("solid/phone"),
     * otherwise an empty string.
     */
    public function normalizeId(mixed $value): string
    {
        $id = trim((string) $value);

        if (!preg_match('~^(?:'.implode('|', self::STYLES).')/[a-z0-9]+(?:-[a-z0-9]+)*$~', $id)) {
            return '';
        }

        $svgDir = $this->getSvgDir();

        return null !== $svgDir && is_file($svgDir.'/'.$id.'.svg') ? $id : '';
    }

    /**
     * Inline SVG markup of an icon, or an empty string if it does not exist.
     * The licence comment of Font Awesome is kept, as the licence (CC BY 4.0)
     * requires attribution.
     */
    public function getSvg(mixed $value): string
    {
        $id = $this->normalizeId($value);

        if ('' === $id) {
            return '';
        }

        $svg = file_get_contents($this->getSvgDir().'/'.$id.'.svg');

        if (false === $svg || !str_starts_with($svg = trim($svg), '<svg ')) {
            return '';
        }

        // The explicit size keeps the icon small where the stylesheet is not
        // loaded (back end preview); the stylesheet overrides it.
        return '<svg class="stickylinks__svg" aria-hidden="true" focusable="false" width="1em" height="1em" fill="currentColor" '
            .substr($svg, 5);
    }

    private function getSvgDir(): string|null
    {
        if (null === $this->svgDir) {
            $this->svgDir = false;

            if (InstalledVersions::isInstalled(self::PACKAGE)) {
                $path = InstalledVersions::getInstallPath(self::PACKAGE);

                if (null !== $path && is_dir($path.'/svgs')) {
                    $this->svgDir = (realpath($path.'/svgs') ?: $path.'/svgs');
                }
            }
        }

        return $this->svgDir ?: null;
    }
}
