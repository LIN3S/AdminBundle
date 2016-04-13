<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Registry;

use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use LIN3S\AdminBundle\Configuration\Registry\Exception\EntityConfigAlreadyRegistedException;

interface EntityConfigurationRegistryInterface
{
    /**
     * Adds new entity configuration to the registry
     *
     * @param EntityConfiguration $entityConfiguration
     *
     * @throws EntityConfigAlreadyRegistedException if config already registered
     */
    public function add(EntityConfiguration $entityConfiguration);

    /**
     * Returns entity configuration for the given entity name
     *
     * @param string $entityName
     *
     * @return \LIN3S\AdminBundle\Configuration\EntityConfiguration
     */
    public function get($entityName);
}
