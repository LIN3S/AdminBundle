<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Registry;

use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use LIN3S\AdminBundle\Configuration\Registry\Exception\EntityConfigAlreadyRegisteredException;

/**
 * Entity configuration registry base.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface EntityConfigurationRegistryInterface
{
    /**
     * Adds new entity configuration to the registry.
     *
     * @param EntityConfiguration $entityConfiguration
     *
     * @throws EntityConfigAlreadyRegisteredException if config already registered
     */
    public function add(EntityConfiguration $entityConfiguration);

    /**
     * Returns entity configuration for the given entity name.
     *
     * @param string $entityName
     *
     * @return EntityConfiguration
     */
    public function get($entityName);
}
