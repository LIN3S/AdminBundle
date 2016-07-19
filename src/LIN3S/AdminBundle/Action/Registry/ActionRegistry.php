<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Action\Registry;

use LIN3S\AdminBundle\Action\ActionType;

class ActionRegistry
{
    /**
     * @var ActionType[]
     */
    protected $actions = [];

    /**
     * {@inheritdoc}
     */
    public function add(ActionType $actionInterface)
    {
        if (isset($this->actions[get_class($actionInterface)])) {
            throw new \InvalidArgumentException(
                sprintf('Class %s already registered in action list', get_class($actionInterface))
            );
        }

        $this->actions[get_class($actionInterface)] = $actionInterface;
    }

    /**
     * @return ActionType
     */
    public function get($className)
    {
        if (isset($this->actions[$className])) {
            return $this->actions[$className];
        }

        throw new \InvalidArgumentException();
    }
}
