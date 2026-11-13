<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

namespace Tonsinn\StickyLinksBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\String\HtmlAttributes;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tonsinn\StickyLinksBundle\Icon\FontAwesomeIconProvider;
use Tonsinn\StickyLinksBundle\Icon\RockSolidIconProvider;

/**
 * A single icon of the sticky links bar. Depending on its type it is either a
 * link whose text slides out on hover, or a button that opens a flyout panel
 * showing a Contao article.
 */
#[AsContentElement(self::TYPE, category: 'miscellaneous')]
class StickyLinksItemController extends AbstractContentElementController
{
    public const TYPE = 'sticky_links_item';

    public const TYPE_LINK = 'link';

    public const TYPE_PANEL = 'panel';

    public const ITEM_TYPES = [self::TYPE_LINK, self::TYPE_PANEL];

    public const SOURCE_FONTAWESOME = 'fontawesome';

    public const SOURCE_ROCKSOLID = 'rocksolid';

    public const ICON_SOURCES = [self::SOURCE_FONTAWESOME, self::SOURCE_ROCKSOLID];

    /**
     * Articles that are being rendered right now. Prevents an endless loop if
     * an article shown in a panel contains the sticky links bar itself.
     *
     * @var array<int, true>
     */
    private static array $renderingArticles = [];

    public function __construct(
        private readonly InsertTagParser $insertTagParser,
        private readonly ScopeMatcher $scopeMatcher,
        private readonly FontAwesomeIconProvider $fontAwesome,
        private readonly RockSolidIconProvider $rockSolid,
    ) {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $itemType = \in_array($model->stickyLinksType, self::ITEM_TYPES, true)
            ? $model->stickyLinksType
            : self::TYPE_LINK;

        $template->set('item_type', $itemType);
        $template->set('text', trim((string) $model->stickyLinksText));
        $template->set('color', StickyLinksController::getColor($model->stickyLinksColor));
        $template->set('background', StickyLinksController::getColor($model->stickyLinksBackground));

        $this->addIcon($template, $model);

        $href = '';
        $linkAttributes = new HtmlAttributes();
        $panel = '';
        $articleId = (int) $model->stickyLinksArticle;

        if (self::TYPE_LINK === $itemType) {
            // Link handling follows the core hyperlink element
            $href = trim($this->insertTagParser->replaceInline($model->url ?? ''));

            if ('' !== $href && Validator::isRelativeUrl($href)) {
                $href = $request->getBasePath().'/'.$href;
            }

            if ('' !== $href) {
                $linkAttributes->set('href', $href);

                if ($model->target) {
                    $linkAttributes
                        ->set('target', '_blank')
                        ->set('rel', 'noreferrer noopener')
                    ;
                }
            }
        } elseif ($articleId > 0 && !$this->scopeMatcher->isBackendRequest($request)) {
            $panel = $this->renderArticle($articleId);
        }

        $template->set('href', $href);
        $template->set('link_attributes', $linkAttributes);
        $template->set('article_id', $articleId);
        $template->set('panel', $panel);
        $template->set('panel_id', 'stickylinks-panel-'.(int) $model->id);

        return $template->getResponse();
    }

    private function addIcon(FragmentTemplate $template, ContentModel $model): void
    {
        $svg = '';
        $glyph = '';
        $fonts = [];

        if (self::SOURCE_ROCKSOLID === $model->stickyLinksIconSource) {
            $fonts = $this->rockSolid->getWebFonts();

            // Without the font files the code point would only render as an empty box
            if ([] !== $fonts) {
                $glyph = $this->rockSolid->getCharacter($model->stickyLinksIconRs);
            }
        } else {
            $svg = $this->fontAwesome->getSvg($model->stickyLinksIconFa);
        }

        $template->set('icon_svg', $svg);
        $template->set('icon_glyph', $glyph);
        $template->set('icon_fonts', '' !== $glyph ? $fonts : []);
    }

    private function renderArticle(int $articleId): string
    {
        if (isset(self::$renderingArticles[$articleId])) {
            return '';
        }

        self::$renderingArticles[$articleId] = true;

        try {
            return trim($this->insertTagParser->replace('{{insert_article::'.$articleId.'}}'));
        } finally {
            unset(self::$renderingArticles[$articleId]);
        }
    }
}
