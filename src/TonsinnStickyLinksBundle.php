<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

namespace Tonsinn\StickyLinksBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TonsinnStickyLinksBundle extends Bundle
{
    /**
     * Contao 5 resources (contao/, public/) live in the bundle root, not in src/Resources.
     */
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
