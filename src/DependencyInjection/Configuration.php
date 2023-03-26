<?php

/**
 * This file is part of the bugloos/responder-bundle project.
 * (c) Bugloos <https://bugloos.com/>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bugloos\ResponderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bugloos_responder');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('default_max_items_per_page')
                    ->defaultValue(100)
                ->end()
                ->scalarNode('default_items_per_page')
                    ->defaultValue(20)
                ->end()
                ->scalarNode('page_key_in_request')
                    ->defaultValue('page')
                ->end()
                ->scalarNode('items_per_page_key_in_request')
                    ->defaultValue('itemsPerPage')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
