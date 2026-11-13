<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

namespace Tonsinn\StickyLinksBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tonsinn\StickyLinksBundle\Controller\ContentElement\StickyLinksController;
use Tonsinn\StickyLinksBundle\Controller\ContentElement\StickyLinksItemController;
use Tonsinn\StickyLinksBundle\Icon\FontAwesomeIconProvider;
use Tonsinn\StickyLinksBundle\Icon\RockSolidIconProvider;

/**
 * Back end callbacks of the sticky links fields in tl_content and tl_module.
 */
class StickyLinksListener
{
    public function __construct(
        private readonly Connection $connection,
        private readonly TranslatorInterface $translator,
        private readonly FontAwesomeIconProvider $fontAwesome,
        private readonly RockSolidIconProvider $rockSolid,
    ) {
    }

    /**
     * Uses the visual RockSolid icon picker for the RockSolid icon field, if
     * that optional extension is installed. Otherwise the field stays a plain
     * select menu listing the glyphs of the font.
     */
    #[AsCallback(table: 'tl_content', target: 'config.onload')]
    public function useIconPicker(DataContainer|null $dc = null): void
    {
        $fontPath = $this->rockSolid->getFontPath();

        if (null === $fontPath || !isset($GLOBALS['BE_FFL']['rocksolid_icon_picker'])) {
            return;
        }

        $field = &$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksIconRs'];

        $field['inputType'] = 'rocksolid_icon_picker';
        $field['eval']['iconFont'] = $fontPath;
        $field['eval']['tl_class'] = 'clr';

        unset($field['eval']['chosen'], $field['eval']['includeBlankOption']);
    }

    /**
     * The RockSolid font is only offered if the installation contains it - or
     * if the element already uses it, so the stored value stays visible.
     *
     * @return list<string>
     */
    #[AsCallback(table: 'tl_content', target: 'fields.stickyLinksIconSource.options')]
    public function getIconSources(DataContainer|null $dc = null): array
    {
        $sources = [StickyLinksItemController::SOURCE_FONTAWESOME];
        $current = $dc?->getCurrentRecord()['stickyLinksIconSource'] ?? null;

        if ($this->rockSolid->isAvailable() || StickyLinksItemController::SOURCE_ROCKSOLID === $current) {
            $sources[] = StickyLinksItemController::SOURCE_ROCKSOLID;
        }

        return $sources;
    }

    /**
     * @return array<string, array<string, string>>
     */
    #[AsCallback(table: 'tl_content', target: 'fields.stickyLinksIconFa.options')]
    public function getFontAwesomeIcons(): array
    {
        return $this->fontAwesome->getIcons();
    }

    /**
     * @return array<string, string>
     */
    #[AsCallback(table: 'tl_content', target: 'fields.stickyLinksIconRs.options')]
    public function getRockSolidIcons(): array
    {
        return $this->rockSolid->getGlyphs();
    }

    /**
     * The icon picker widget does not validate its value, so make sure only a
     * hex code point is stored.
     */
    #[AsCallback(table: 'tl_content', target: 'fields.stickyLinksIconRs.save')]
    public function saveRockSolidIcon(mixed $value): string
    {
        $value = trim((string) $value);

        if ('' === $value) {
            return '';
        }

        $code = $this->rockSolid->normalizeCode($value);

        if ('' === $code) {
            throw new \InvalidArgumentException($this->translator->trans('ERR.stickyLinksIcon', [], 'contao_default'));
        }

        return $code;
    }

    /**
     * All articles, grouped by the page they belong to.
     *
     * @return array<string, array<int, string>>
     */
    #[AsCallback(table: 'tl_content', target: 'fields.stickyLinksArticle.options')]
    public function getArticles(): array
    {
        $rows = $this->connection->fetchAllAssociative(
            'SELECT a.id, a.title, a.inColumn, p.title AS pageTitle
               FROM tl_article a
          LEFT JOIN tl_page p ON p.id = a.pid
           ORDER BY p.title, a.sorting',
        );

        $options = [];

        foreach ($rows as $row) {
            $page = (string) ($row['pageTitle'] ?? '') ?: '-';
            $options[$page][(int) $row['id']] = \sprintf('%s (ID %d, %s)', $row['title'], $row['id'], $row['inColumn']);
        }

        return $options;
    }

    /**
     * All sticky links bars, labelled with the article and page they are stored in.
     *
     * @return array<int, string>
     */
    #[AsCallback(table: 'tl_module', target: 'fields.stickyLinksElement.options')]
    public function getBars(): array
    {
        $rows = $this->connection->fetchAllAssociative(
            "SELECT c.id, c.headline, a.title AS articleTitle, p.title AS pageTitle
               FROM tl_content c
          LEFT JOIN tl_article a ON a.id = c.pid AND c.ptable = 'tl_article'
          LEFT JOIN tl_page p ON p.id = a.pid
              WHERE c.type = ?
           ORDER BY p.title, a.title, c.sorting",
            [StickyLinksController::TYPE],
        );

        $options = [];

        foreach ($rows as $row) {
            $location = implode(' › ', array_filter([(string) ($row['pageTitle'] ?? ''), (string) ($row['articleTitle'] ?? '')]));

            $options[(int) $row['id']] = '' !== $location
                ? \sprintf('%s (ID %d)', $location, $row['id'])
                : \sprintf('ID %d', $row['id']);
        }

        return $options;
    }
}
