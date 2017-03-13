<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle;

use LIN3S\AdminBundle\DependencyInjection\CompilerPass\ActionPass;
use LIN3S\AdminBundle\DependencyInjection\CompilerPass\ListFieldTypePass;
use LIN3S\AdminBundle\DependencyInjection\CompilerPass\ListFiltersTypePass;
use LIN3S\AdminBundle\DependencyInjection\Lin3sAdminExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * AdminBundle's kernel class.
 *
 * @author Gorka Laucirica <gorka.lauzirka@gmail.com>
 */
class Lin3sAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ListFieldTypePass());
        $container->addCompilerPass(new ListFiltersTypePass());
        $container->addCompilerPass(new ActionPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new Lin3sAdminExtension();
    }
}
