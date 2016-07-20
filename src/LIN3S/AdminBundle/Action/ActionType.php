<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Action;

use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Action type interface.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface ActionType
{
    /**
     * Executes logic required to perform the action requested. It's called once for each entity.
     *
     * @param mixed               $entity  Entity in which you can apply changes
     * @param EntityConfiguration $config  The entity configuration
     * @param Request             $request The request
     * @param array               $options The options that will be used to execute the action
     *
     * @return Response Response to the action, can be a page render or a redirect
     */
    public function execute($entity, EntityConfiguration $config, Request $request, $options = []);
}
