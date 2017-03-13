<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Action compiler class.
 *
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
final class ActionPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('lin3s_admin.action.registry')) {
            return;
        }

        $registry = $container->getDefinition('lin3s_admin.action.registry');
        foreach ($container->findTaggedServiceIds('lin3s_admin.action') as $id => $tags) {
            foreach ($tags as $attributes) {
                $registry->addMethodCall('register', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
