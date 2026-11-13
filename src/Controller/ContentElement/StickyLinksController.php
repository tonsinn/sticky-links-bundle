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
use Contao\CoreBundle\Fragment\Reference\ContentElementReference;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The bar of sticky links. It is fixed to the left or right edge of the
 * browser window and renders its nested "sticky_links_item" elements. Position,
 * size and default colours apply to all icons of the bar.
 */
#[AsContentElement(
    self::TYPE,
    category: 'miscellaneous',
    nestedFragments: ['allowedTypes' => [StickyLinksItemController::TYPE]],
)]
class StickyLinksController extends AbstractContentElementController
{
    public const TYPE = 'sticky_links';

    public const SIDES = ['left', 'right'];

    public const VERTICALS = ['top', 'middle', 'bottom'];

    public const SIZES = ['s', 'm', 'l'];

    public const MOBILE_MODES = ['edge', 'bottom', 'hide'];

    public const OFFSET_UNITS = ['px', 'rem', 'vh', '%'];

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        /** @var array<ContentElementReference> $references */
        $references = $template->get('nested_fragments');

        // Tell the children that they are rendered inside a bar (available as "properties.stickylinks")
        foreach ($references as $index => $reference) {
            $properties = $reference->attributes['templateProperties'] ?? [];
            $properties['stickylinks'] = ['index' => $index];

            $reference->attributes['templateProperties'] = $properties;
        }

        $template->set('nested_fragments', $references);
        $template->set('count', \count($references));
        $template->set('side', self::pick($model->stickyLinksSide, self::SIDES, 'left'));
        $template->set('vertical', self::pick($model->stickyLinksVertical, self::VERTICALS, 'middle'));
        $template->set('size', self::pick($model->stickyLinksSize, self::SIZES, 'm'));
        $template->set('mobile', self::pick($model->stickyLinksMobile, self::MOBILE_MODES, 'edge'));

        // Empty values are omitted in the template, so the defaults of
        // sticky-links.css stay in place.
        $template->set('offset', $this->getOffset($model->stickyLinksOffset));
        $template->set('color', self::getColor($model->stickyLinksColor));
        $template->set('background', self::getColor($model->stickyLinksBackground));

        return $template->getResponse();
    }

    /**
     * Turns a hex value stored without a leading hash into a CSS colour.
     * Returns an empty string for anything that is not a valid hex colour.
     */
    public static function getColor(mixed $value): string
    {
        $hex = ltrim(trim((string) $value), '#');

        if (!preg_match('/^(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $hex)) {
            return '';
        }

        return '#'.$hex;
    }

    /**
     * @param list<string> $allowed
     */
    private static function pick(mixed $value, array $allowed, string $default): string
    {
        return \in_array($value, $allowed, true) ? $value : $default;
    }

    /**
     * Turns the serialized inputUnit value into a CSS length such as "120px".
     */
    private function getOffset(mixed $value): string
    {
        $data = StringUtil::deserialize($value, true);
        $number = trim((string) ($data['value'] ?? ''));
        $unit = (string) ($data['unit'] ?? '');

        if (!preg_match('/^\d{1,4}$/', $number) || !\in_array($unit, self::OFFSET_UNITS, true)) {
            return '';
        }

        return $number.$unit;
    }
}
