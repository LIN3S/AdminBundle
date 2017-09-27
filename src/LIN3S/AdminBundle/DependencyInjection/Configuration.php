<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
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
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('lin3s_admin')
            ->children()
                ->arrayNode('entities')->requiresAtLeastOneElement()
                ->prototype('array')
                    ->children()
                        ->scalarNode('repository_service_id')
                            ->defaultValue('lin3s_admin.doctrine_repository')
                        ->end()
                        ->arrayNode('name')
                            ->children()
                                ->scalarNode('singular')->end()
                                ->scalarNode('plural')->end()
                            ->end()
                        ->end()
                        ->scalarNode('class')
                            ->isRequired(true)
                        ->end()
                        ->arrayNode('actions')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('name')->end()
                                    ->scalarNode('type')->end()
                                    ->arrayNode('options')
                                        ->beforeNormalization()
                                            ->ifArray()
                                            ->then(function ($options) {
                                                foreach ($options as $key => $option) {
                                                    if (is_array($option)) {
                                                        $options[$key] = json_encode($option);
                                                    }
                                                }

                                                return $options;
                                            })
                                        ->end()
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
                                ->integerNode('amount_per_page')
                                    ->defaultValue(10)
                                ->end()
                                ->arrayNode('fields')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('name')->end()
                                            ->scalarNode('type')->end()
                                            ->arrayNode('options')
                                                ->beforeNormalization()
                                                ->ifArray()
                                                ->then(function ($options) {
                                                    foreach ($options as $key => $option) {
                                                        if (is_array($option)) {
                                                            $options[$key] = json_encode($option);
                                                        }
                                                    }

                                                    return $options;
                                                })
                                                ->end()
                                                ->prototype('scalar')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('filters')
                                    ->prototype('array')
                                        ->children()
                                            ->scalarNode('type')->end()
                                            ->scalarNode('name')->end()
                                            ->scalarNode('field')->end()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('global_actions')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->arrayNode('order_by')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
