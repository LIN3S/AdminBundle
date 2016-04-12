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

use Doctrine\Common\Persistence\ObjectManager;
use LIN3S\AdminBundle\Action\ActionInterface;
use LIN3S\AdminBundle\Action\ActionType;
use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use LIN3S\AdminBundle\Form\FormHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class EditActionType implements ActionType
{
    /**
     * @var RouterInterface
     */
    private $router;

    private $formHandler;

    private $manager;

    private $twig;

    public function __construct(FormHandler $formHandler, ObjectManager $manager, \Twig_Environment $twig)
    {
        $this->formHandler = $formHandler;
        $this->manager = $manager;
        $this->twig = $twig;
    }

    /**
     * @inheritDoc
     */
    public function execute($entity, EntityConfiguration $config, Request $request, $options = null)
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

        $manager = $this->manager->getRepository($config->className());

        $entity = $manager->findOneBy([$config->idField() => $id]);

        if (!$entity) {
            throw new NotFoundHttpException();
        }

        $form = $this->formHandler->handleForm(
            $config->form(), $entity, $request
        );

//        if ($form->isValid()) {
//            $this->addFlash(
//                'lin3s_admin_success',
//                sprintf('%s edited successfully', $config->name())
//            );
//        } else if($form->isSubmitted()) {
//            $this->addFlash(
//                'lin3s_admin_error',
//                sprintf('Errors while saving %s. Please check all fields and try again', $config->name())
//            );
//        }

        return new Response(
            $this->twig->render('@LIN3SAdminBundle:',  [
                'entity'       => $entity,
                'entityConfig' => $config,
                'form'         => $form->createView(),
            ])
        );
    }
}
