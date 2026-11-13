<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

use Tonsinn\StickyLinksBundle\Controller\ContentElement\StickyLinksController;
use Tonsinn\StickyLinksBundle\Controller\ContentElement\StickyLinksItemController;

/*
 * Palettes
 *
 * The element types themselves are registered automatically through the
 * #[AsContentElement] attributes, so only palettes and fields are declared
 * here. Option lists and the icon picker are wired up in StickyLinksListener.
 */
$GLOBALS['TL_DCA']['tl_content']['palettes'][StickyLinksController::TYPE] =
    '{type_legend},type,headline,title;'
    .'{stickylinks_position_legend},stickyLinksSide,stickyLinksVertical,stickyLinksOffset,stickyLinksSize,stickyLinksMobile;'
    .'{stickylinks_color_legend},stickyLinksColor,stickyLinksBackground;'
    .'{template_legend:hide},customTpl;'
    .'{protected_legend:hide},protected;'
    .'{expert_legend:hide},cssID;'
    .'{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes'][StickyLinksItemController::TYPE] =
    '{type_legend},type;'
    .'{stickylinks_item_legend},stickyLinksText,stickyLinksType;'
    .'{stickylinks_icon_legend},stickyLinksIconSource;'
    .'{stickylinks_color_legend},stickyLinksColor,stickyLinksBackground;'
    .'{template_legend:hide},customTpl;'
    .'{protected_legend:hide},protected;'
    .'{expert_legend:hide},cssID;'
    .'{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'stickyLinksType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'stickyLinksIconSource';

// "url" and "target" are core fields
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['stickyLinksType_'.StickyLinksItemController::TYPE_LINK] = 'url,target';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['stickyLinksType_'.StickyLinksItemController::TYPE_PANEL] = 'stickyLinksArticle';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['stickyLinksIconSource_'.StickyLinksItemController::SOURCE_FONTAWESOME] = 'stickyLinksIconFa';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['stickyLinksIconSource_'.StickyLinksItemController::SOURCE_ROCKSOLID] = 'stickyLinksIconRs';

/*
 * Fields of the bar
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksSide'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksSide'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => StickyLinksController::SIDES,
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksSideOptions'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(16) COLLATE ascii_bin NOT NULL default 'left'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksVertical'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksVertical'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => StickyLinksController::VERTICALS,
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksVerticalOptions'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(16) COLLATE ascii_bin NOT NULL default 'middle'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksOffset'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksOffset'],
    'exclude' => true,
    'inputType' => 'inputUnit',
    'options' => StickyLinksController::OFFSET_UNITS,
    'eval' => ['rgxp' => 'natural', 'maxlength' => 4, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksSize'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksSize'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => StickyLinksController::SIZES,
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksSizeOptions'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(16) COLLATE ascii_bin NOT NULL default 'm'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksMobile'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksMobile'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => StickyLinksController::MOBILE_MODES,
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksMobileOptions'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(16) COLLATE ascii_bin NOT NULL default 'edge'",
];

/*
 * Colours - used by the bar (default for all icons) and by the single icon
 * (overrides the default). An empty value means "inherit".
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksColor'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksColor'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 6, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard'],
    'sql' => "varchar(6) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksBackground'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksBackground'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 6, 'colorpicker' => true, 'isHexColor' => true, 'decodeEntities' => true, 'tl_class' => 'w50 wizard'],
    'sql' => "varchar(6) COLLATE ascii_bin NOT NULL default ''",
];

/*
 * Fields of the single icon
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksText'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksText'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksType'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksType'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => StickyLinksItemController::ITEM_TYPES,
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksTypeOptions'],
    'eval' => ['submitOnChange' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(16) COLLATE ascii_bin NOT NULL default 'link'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksArticle'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksArticle'],
    'exclude' => true,
    'inputType' => 'select',
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'clr w50'],
    'sql' => 'int(10) unsigned NOT NULL default 0',
    'relation' => ['table' => 'tl_article', 'type' => 'hasOne', 'load' => 'lazy'],
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksIconSource'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksIconSource'],
    'exclude' => true,
    'inputType' => 'select',
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksIconSourceOptions'],
    'eval' => ['submitOnChange' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(16) COLLATE ascii_bin NOT NULL default 'fontawesome'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksIconFa'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksIconFa'],
    'exclude' => true,
    'inputType' => 'select',
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksIconFaGroups'],
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(96) COLLATE ascii_bin NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['stickyLinksIconRs'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['stickyLinksIconRs'],
    'exclude' => true,
    'inputType' => 'select',
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(8) COLLATE ascii_bin NOT NULL default ''",
];
