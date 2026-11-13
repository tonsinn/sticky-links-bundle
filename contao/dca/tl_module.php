<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

use Tonsinn\StickyLinksBundle\Controller\FrontendModule\StickyLinksModuleController;

$GLOBALS['TL_DCA']['tl_module']['palettes'][StickyLinksModuleController::TYPE] =
    '{title_legend},name,type;'
    .'{config_legend},stickyLinksElement;'
    .'{template_legend:hide},customTpl;'
    .'{protected_legend:hide},protected;'
    .'{expert_legend:hide},cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['stickyLinksElement'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['stickyLinksElement'],
    'exclude' => true,
    'inputType' => 'select',
    'eval' => ['mandatory' => true, 'includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
    'sql' => 'int(10) unsigned NOT NULL default 0',
];
