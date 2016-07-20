<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * AdminBundle's configuration class.
 *
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('lin3_s_admin')
            ->children()
                ->arrayNode('entities')->requiresAtLeastOneElement()
                ->prototype('array')
                    ->children()
                        ->scalarNode('class')
                            ->isRequired(true)
                        ->end()
                        ->arrayNode('actions')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('class')->end()
                                    ->arrayNode('options')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('list')
                            ->children()
                                ->arrayNode('actions')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->integerNode('amountPerPage')
                                    ->defaultValue(10)
                                ->end()
                                ->arrayNode('fields')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('class')->end()
                                            ->arrayNode('options')
                                                ->prototype('scalar')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('filters')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('class')->end()
                                            ->scalarNode('field')->end()
                                            ->arrayNode('options')
                                                ->prototype('scalar')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('globalActions')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->arrayNode('orderBy')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
