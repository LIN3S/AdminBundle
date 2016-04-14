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

use LIN3S\AdminBundle\Action\Action;
use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use LIN3S\AdminBundle\ListFields\ListField;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class EntityConfigurationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('lin3s_admin.configuration.entity_configuration_registry')) {
            return;
        }

        $registry = $container->getDefinition('lin3s_admin.configuration.entity_configuration_registry');
        $config = $container->getParameter('lin3s_admin.config');

        foreach ($config['entities'] as $entityName => $entityConfig) {
            // Define list fields
            $listFields = [];
            foreach ($entityConfig['list']['fields'] as $fieldName => $field) {
                $container->setDefinition(
                    sprintf('lin3s_admin.config.%s.field.%s', $entityName, $fieldName),
                    new Definition(
                        ListField::class, [
                            $fieldName,
                            $container->getDefinition($field['class']),
                            $field['options'],
                        ]
                    )
                )->setPublic(false);
                $listFields[] = $container->getDefinition(sprintf('lin3s_admin.config.%s.field.%s', $entityName, $fieldName));
            }

            // Define actions
            $actions = [];
            foreach ($entityConfig['actions'] as $actionName => $action) {
                $container->setDefinition(
                    sprintf('lin3s_admin.config.%s.action.%s', $entityName, $actionName),
                    new Definition(
                        Action::class, [
                            $actionName,
                            $container->getDefinition($action['class']),
                            $action['options'],
                        ]
                    )
                )->setPublic(false);
                $actions[] = $container->getDefinition(sprintf('lin3s_admin.config.%s.action.%s', $entityName, $actionName));
            }

            // Define config class
            $container->setDefinition(
                sprintf('lin3s_admin.config.%s', $entityName),
                new Definition(
                    EntityConfiguration::class,
                    [
                        $entityName,
                        $entityConfig['class'],
                        $actions,
                        $entityConfig['list']['actions'],
                        $listFields,
                        $entityConfig['list']['globalActions']
                    ]
                )
            )->setPublic(false);
            $registry->addMethodCall('add', [
                new Reference(sprintf('lin3s_admin.config.%s', $entityName)),
            ]);
        }
    }
}
