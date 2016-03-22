<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Action\Registry;

use LIN3S\AdminBundle\Action\ActionInterface;

class ActionRegistry
{
    /**
     * @var ActionInterface[]
     */
    protected $actions = [];

    /**
     * @inheritdoc
     */
    public function add(ActionInterface $actionInterface)
    {
        if(isset($this->actions[get_class($actionInterface)])) {
            throw new \InvalidArgumentException(
                sprintf('Class %s already registered in action list', get_class($actionInterface))
            );
        }

        $this->actions[get_class($actionInterface)] = $actionInterface;
    }

    /**
     * @return ActionInterface
     */
    public function get($className)
    {
        if (isset($this->actions[$className])) {
            return $this->actions[$className];
        }

        foreach($this->actions as $action) {
            if($action->alias() == $className) {
                return $action;
            }
        }

        throw new \InvalidArgumentException;
    }
}
