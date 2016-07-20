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
use LIN3S\AdminBundle\Configuration\Registry\Exception\EntityConfigNotFoundException;

/**
 * Entity configuration not found exception.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class EntityConfigurationRegistry implements EntityConfigurationRegistryInterface
{
    /**
     * Array which contains the configurations.
     *
     * @var array
     */
    protected $configs;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->configs = [];
    }

    /**
     * {@inheritdoc}
     */
    public function add(EntityConfiguration $entityConfiguration)
    {
        if (isset($this->configs[$entityConfiguration->name()])) {
            throw new EntityConfigAlreadyRegisteredException();
        }

        $this->configs[$entityConfiguration->name()] = $entityConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function get($entityName)
    {
        if (!isset($this->configs[$entityName])) {
            throw new EntityConfigNotFoundException();
        }

        return $this->configs[$entityName];
    }
}
