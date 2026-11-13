<?php

declare(strict_types=1);

/*
 * This file is part of the sticky-links bundle.
 *
 * (c) Mathias Ebert
 *
 * @license LGPL-3.0-or-later
 */

namespace Tonsinn\StickyLinksBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('tonsinn_sticky_links');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->scalarNode('rocksolid_font')
                    ->info('Path to the SVG file of the RockSolid icon font, relative to the project directory. Leave empty to detect the font of the Tao or Oneo theme automatically.')
                    ->example('files/tao/fonts/rocksolid-icons.svg')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
