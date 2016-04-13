<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle;

use LIN3S\AdminBundle\DependencyInjection\CompilerPass\ActionPass;
use LIN3S\AdminBundle\DependencyInjection\CompilerPass\EntityConfigurationPass;
use LIN3S\AdminBundle\DependencyInjection\CompilerPass\ListFieldTypePass;
use LIN3S\AdminBundle\DependencyInjection\LIN3SAdminExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle's kernel class.
 *
 * @author Gorka Laucirica <gorka@lin3s.com>
 */
class LIN3SAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ListFieldTypePass());
        $container->addCompilerPass(new EntityConfigurationPass());
        $container->addCompilerPass(new ActionPass());
    }

    public function getContainerExtension()
    {
        return new LIN3SAdminExtension();
    }
}
