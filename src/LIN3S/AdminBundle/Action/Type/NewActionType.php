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

use LIN3S\AdminBundle\Action\ActionType;
use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use LIN3S\AdminBundle\Form\FormHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;

class NewActionType implements ActionType
{
    private $formHandler;

    private $twig;

    private $session;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(FormHandler $formHandler, \Twig_Environment $twig, Session $session, RouterInterface $router)
    {
        $this->formHandler = $formHandler;
        $this->twig = $twig;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @inheritDoc
     */
    public function execute($entity, EntityConfiguration $config, Request $request, $options = null)
    {
        if (!isset($options['form'])) {
            throw new \InvalidArgumentException(
                sprintf('NewActionType requires a form class as an option')
            );
        }

        $form = $this->formHandler->handleForm(
            $options['form'], $entity, $request
        );

        if ($form->isValid()) {
            $this->session->getFlashBag()->add(
                'lin3s_admin_success',
                sprintf('%s created successfully', $config->name())
            );

            return new RedirectResponse(
                $this->router->generate('lin3s_admin_custom', [
                    'action' => isset($options['redirectAction']) ? $options['redirectAction'] : 'edit',
                    'entity' => $config->name(),
                    'id'     => $form->getData()->id(),
                ])
            );
        } else if ($form->isSubmitted()) {
            $this->session->getFlashBag()->add(
                'lin3s_admin_error',
                sprintf('Errors while creating %s. Please check all fields and try again', $config->name())
            );
        }

        return new Response(
            $this->twig->render('LIN3SAdminBundle:Admin:new.html.twig', [
                'entity'       => $entity,
                'entityConfig' => $config,
                'form'         => $form->createView(),
            ])
        );
    }

    private function getEntityId($entity, EntityConfiguration $config)
    {
        if (method_exists($entity, $config->idField())) {
            return call_user_func([$entity, $config->idField()]);
        } elseif (method_exists($entity, 'get' . ucfirst($config->idField()))) {
            return call_user_func([$entity, 'get' . ucfirst($config->idField())]);
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
    }
}
