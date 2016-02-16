<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Action\Type;

use LIN3S\AdminBundle\Action\ActionInterface;
use LIN3S\AdminBundle\Configuration\EntityConfigurationInterface;
use LIN3S\AdminBundle\Entity\Entity;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class EditAction implements ActionInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {

        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Edit';
    }

    /**
     * @inheritDoc
     */
    public function alias()
    {
        return 'edit';
    }

    /**
     * @inheritDoc
     */
    public function execute($entity, EntityConfigurationInterface $config)
    {
        return new RedirectResponse($this->router->generate('lin3s_admin_edit', [
            'entity' => $config->name(),
            'id'     => $entity->id(),
        ]));
    }

}
