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

/**
 * Action type registry.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class ActionRegistry
{
    /**
     * Array which contains actions.
     *
     * @var ActionType[]
     */
    protected $actions;

    /**
     * Constructor.
     *
     * @param array $actions Array which contains actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    /**
     * Adds the given action inside collection of action types.
     *
     * @param ActionType $actionType The action type
     */
    public function add(ActionType $actionType)
    {
        if (isset($this->actions[get_class($actionType)])) {
            throw new \InvalidArgumentException(
                sprintf('Class %s already registered in action list', get_class($actionType))
            );
        }

        $this->actions[get_class($actionType)] = $actionType;
    }

    /**
     * Gets the action of class name given.
     *
     * @param string $className The class name
     *
     * @return ActionType
     */
    public function get($className)
    {
        if (!isset($this->actions[$className])) {
            throw new \InvalidArgumentException(
                sprintf('The given "%s" class name does not match with any key of actions collection', $className)
            );
        }

        return $this->actions[$className];
    }
}
