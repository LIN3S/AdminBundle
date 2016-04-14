<?php

namespace LIN3S\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
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
