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
use LIN3S\AdminBundle\Configuration\EntityConfigurationInterface;
use LIN3S\AdminBundle\Configuration\Registry\Exception\EntityConfigAlreadyRegistedException;
use LIN3S\AdminBundle\Configuration\Registry\Exception\EntityConfigNotFoundException;

class EntityConfigurationRegistry implements EntityConfigurationRegistryInterface
{
    protected $configs = [];

    /**
     * @inheritdoc
     */
    public function add(EntityConfigurationInterface $entityConfiguration)
    {
        if(isset($this->configs[$entityConfiguration->name()])) {
            throw new EntityConfigAlreadyRegistedException();
        }

        $this->configs[$entityConfiguration->name()] = $entityConfiguration;
    }

    /**
     * @inheritdoc
     */
    public function get($entityName)
    {
        if (!isset($this->configs[$entityName])) {
            throw new EntityConfigNotFoundException();
        }

        return $this->configs[$entityName];
    }
}
