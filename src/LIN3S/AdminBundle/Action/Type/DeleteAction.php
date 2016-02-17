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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;

class DeleteAction implements ActionInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Session
     */
    private $session;

    public function __construct(RouterInterface $router, Session $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Delete';
    }

    /**
     * @inheritDoc
     */
    public function alias()
    {
        return 'delete';
    }


    /**
     * @inheritDoc
     */
    public function execute($entity, EntityConfigurationInterface $config)
    {
        $this->session->getFlashBag()->add('lin3s_admin_error', 'Not implemented yet!');

        return new RedirectResponse($this->router->generate('lin3s_admin_list', [
            'entity' => $config->name(),
        ]));
    }

}
