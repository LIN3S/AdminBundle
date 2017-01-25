<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Model;

use LIN3S\AdminBundle\Configuration\Type\ActionType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Action.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
final class Action
{
    /**
     * The name.
     *
     * @var string
     */
    private $name;

    /**
     * The action type.
     *
     * @var ActionType
     */
    private $type;

    /**
     * Array which contains the options.
     *
     * @var array|null
     */
    private $options;

    /**
     * Constructor.
     *
     * @param string     $name    The name
     * @param ActionType $type    The action type
     * @param array|null $options Array which contains the options
     */
    public function __construct($name, ActionType $type, $options = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Gets the action type.
     *
     * @return ActionType
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Gets the options.
     *
     * @return array|null
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Executes the action type "execute" method with the given params.
     *
     * @param mixed   $entity        Entity in which you can apply changes
     * @param Entity  $configuration The entity configuration
     * @param Request $request       The request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function execute($entity, Entity $configuration, Request $request)
    {
        return $this->type->execute($entity, $configuration, $request, $this->options);
    }
}
