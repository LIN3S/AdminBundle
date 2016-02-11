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

use LIN3S\AdminBundle\Configuration\EntityConfigurationInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface ActionInterface
{
    /**
     * Name that will be shown in batch action list
     *
     * @return string
     */
    public function name();

    /**
     * Unique identifier of the action
     *
     * @return string
     */
    public function alias();

    /**
     * Executes logic required to perform the action requested. It's called once for each entity.
     *
     * @param object $entity Entity in which you can apply changes
     *
     * @return RedirectResponse Redirection that needs to be done after action success
     */
    public function execute($entity, EntityConfigurationInterface $config);
}
