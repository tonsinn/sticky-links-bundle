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

/**
 * Reads the RockSolid icon font that ships with the Tao and Oneo themes.
 *
 * The font is a commercial asset and is never bundled: it is only read from
 * the "files" directory of the installation. As site owners extend the font
 * with glyphs of their own, the glyph list is taken from the SVG font file at
 * runtime instead of being hard-coded.
 */
class RockSolidIconProvider
{
    /**
     * Locations checked when no font is configured explicitly.
     */
    public const DEFAULT_FONTS = [
        'files/tao/fonts/rocksolid-icons.svg',
        'files/oneo/fonts/rocksolid-icons.svg',
    ];

    private const WEB_FORMATS = ['woff2' => 'woff2', 'woff' => 'woff', 'ttf' => 'truetype'];

    private string|false|null $fontPath = null;

    /**
     * @var array<string, string>|null
     */
    private array|null $glyphs = null;

    public function __construct(
        private readonly string $projectDir,
        private readonly string|null $rocksolidFont = null,
    ) {
    }

    public function isAvailable(): bool
    {
        return null !== $this->getFontPath();
    }

    /**
     * Path of the SVG font file relative to the project directory, or null if
     * the installation does not contain the font.
     */
    public function getFontPath(): string|null
    {
        if (null === $this->fontPath) {
            $this->fontPath = false;

            $candidates = $this->rocksolidFont ? [$this->rocksolidFont] : self::DEFAULT_FONTS;

            foreach ($candidates as $candidate) {
                $candidate = ltrim(str_replace('\\', '/', $candidate), '/');

                // Only plain relative paths inside the project are accepted
                if (!preg_match('~^[A-Za-z0-9_\-./]+\.svg$~', $candidate) || str_contains($candidate, '..')) {
                    continue;
                }

                if (is_file($this->projectDir.'/'.$candidate)) {
                    $this->fontPath = $candidate;
                    break;
                }
            }
        }

        return $this->fontPath ?: null;
    }

    /**
     * Web font files lying next to the SVG file, as "public path => CSS format".
     * A leading "public/" or "web/" directory is removed, because it is not
     * part of the URL.
     *
     * @return array<string, string>
     */
    public function getWebFonts(): array
    {
        $fontPath = $this->getFontPath();

        if (null === $fontPath) {
            return [];
        }

        $base = substr($fontPath, 0, -4);
        $fonts = [];

        foreach (self::WEB_FORMATS as $extension => $format) {
            if (is_file($this->projectDir.'/'.$base.'.'.$extension)) {
                $fonts[preg_replace('~^(?:public|web)/~', '', $base).'.'.$extension] = $format;
            }
        }

        return $fonts;
    }

    /**
     * All glyphs of the font as "hex code point => label".
     *
     * @return array<string, string>
     */
    public function getGlyphs(): array
    {
        if (null !== $this->glyphs) {
            return $this->glyphs;
        }

        $this->glyphs = [];
        $fontPath = $this->getFontPath();

        if (null === $fontPath) {
            return $this->glyphs;
        }

        $previous = libxml_use_internal_errors(true);

        try {
            $xml = simplexml_load_file($this->projectDir.'/'.$fontPath, \SimpleXMLElement::class, LIBXML_NONET);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        if (false === $xml || !isset($xml->defs->font->glyph)) {
            return $this->glyphs;
        }

        foreach ($xml->defs->font->glyph as $glyph) {
            $char = (string) ($glyph['unicode'] ?? '');

            // Ligatures and empty entries cannot be addressed by a single code point
            if ('' === $char || 1 !== mb_strlen($char, 'UTF-8')) {
                continue;
            }

            $codePoint = mb_ord($char, 'UTF-8');

            // Ignore white space, control characters and glyphs without an outline
            if (false === $codePoint || $codePoint <= 32 || '' === trim((string) ($glyph['d'] ?? ''))) {
                continue;
            }

            $code = dechex($codePoint);
            $name = trim((string) ($glyph['glyph-name'] ?? ''));

            $this->glyphs[$code] = '' !== $name ? $name.' ('.$code.')' : $code;
        }

        return $this->glyphs;
    }

    /**
     * Normalizes a stored value to a lower-case hex code point. Returns an
     * empty string for anything that is not a valid code point.
     */
    public function normalizeCode(mixed $value): string
    {
        $code = strtolower(trim((string) $value));

        if (!preg_match('/^[0-9a-f]{1,6}$/', $code)) {
            return '';
        }

        $codePoint = hexdec($code);

        return $codePoint > 32 && $codePoint <= 0x10FFFF ? $code : '';
    }

    /**
     * The character to print for a stored code point ("e0e8"), or an empty
     * string if the value is invalid.
     */
    public function getCharacter(mixed $value): string
    {
        $code = $this->normalizeCode($value);

        if ('' === $code) {
            return '';
        }

        return (string) mb_chr((int) hexdec($code), 'UTF-8');
    }
}
