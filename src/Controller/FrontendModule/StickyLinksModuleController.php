<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

namespace Tonsinn\StickyLinksBundle\Controller\FrontendModule;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsFrontendModule;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tonsinn\StickyLinksBundle\Controller\ContentElement\StickyLinksController;

/**
 * Prints an existing sticky links bar. Placed in a page layout, the module
 * shows the bar on every page that uses the layout, while the bar itself is
 * maintained in one place as a content element.
 */
#[AsFrontendModule(self::TYPE, category: 'miscellaneous')]
class StickyLinksModuleController extends AbstractFrontendModuleController
{
    public const TYPE = 'sticky_links';

    protected function getResponse(FragmentTemplate $template, ModuleModel $model, Request $request): Response
    {
        $elementId = (int) $model->stickyLinksElement;

        // Only ever print a bar, even if the stored ID points to another element by now
        if ($elementId > 0) {
            $element = $this->getContaoAdapter(ContentModel::class)->findById($elementId);

            if (null === $element || StickyLinksController::TYPE !== $element->type) {
                $elementId = 0;
            }
        }

        $template->set('element_id', $elementId);

        return $template->getResponse();
    }
}
