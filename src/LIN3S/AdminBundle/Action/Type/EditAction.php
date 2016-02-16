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
        if (method_exists($entity, $config->idField())) {
            $id = call_user_func([$entity, $config->idField()]);
        } elseif (method_exists($entity, 'get' . ucfirst($config->idField()))) {
            $id = call_user_func([$entity, 'get' . ucfirst($config->idField())]);
        } else {
            throw new \Exception(
                sprintf(
                    'You have configured "%s" as id field, not %s public property found nor %s() nor, get%s() methods found',
                    $config->idField(),
                    $config->idField(),
                    $config->idField(),
                    ucfirst($config->idField())
                )
            );
        }

        return new RedirectResponse($this->router->generate('lin3s_admin_edit', [
            'entity' => $config->name(),
            'id'     => $id,
        ]));
    }

}
