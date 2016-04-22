<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ListFiltersTypePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('lin3s_admin.list_filter_type.registry')) {
            return;
        }

        $registry = $container->getDefinition('lin3s_admin.list_filter_type.registry');
        foreach ($container->findTaggedServiceIds('lin3s_admin.list_filter_type') as $id => $attributes) {
            $registry->addMethodCall('add', [new Reference($id)]);
        }
    }
}
