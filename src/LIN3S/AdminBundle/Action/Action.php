<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Action;

use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use Symfony\Component\HttpFoundation\Request;

class Action
{
    private $name;

    /**
     * @var ActionType
     */
    private $type;

    /**
     * @var null
     */
    private $options;

    public function __construct($name, ActionType $type, $options = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return ActionType
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return null
     */
    public function options()
    {
        return $this->options;
    }

    public function execute($entity, EntityConfiguration $configuration, Request $request)
    {
        return $this->type->execute($entity, $configuration, $request, $this->options);
    }
}
