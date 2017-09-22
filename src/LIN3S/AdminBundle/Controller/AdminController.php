<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class AdminController extends Controller
{
    /**
     * List action.
     *
     * @param string  $entity  The entity name
     * @param Request $request The request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($entity, Request $request)
    {
        $entityConfig = $this->get('lin3s_admin.configuration.factory.entity')->createFor($entity);
        $repository = $entityConfig->repository();
        $entities = $repository->findByRequest($request, $entityConfig);
        $totalCount = $repository->countAll($request, $entityConfig);

        return $this->render('@Lin3sAdmin/Admin/list.html.twig', [
            'entities'     => $entities,
            'entityConfig' => $entityConfig,
            'totalCount'   => $totalCount,
        ]);
    }

    /**
     * Custom action.
     *
     * @param string  $entity  The entity name
     * @param string  $action  The action name
     * @param string  $id      The id of the object to be edited
     * @param Request $request The request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function customAction($entity, $action, $id = null, Request $request)
    {
        $entityConfig = $this->get('lin3s_admin.configuration.factory.entity')->createFor($entity);
        $entityObject = null;
        if ($id) {
            $entityObject = $entityConfig->repository()->find($entityConfig, $id);
        }
        if ($id && !$entityObject) {
            throw $this->createNotFoundException(
                sprintf(
                    '%s not found for id "%s"',
                    $entityConfig->name(),
                    $id
                )
            );
        }
        try {
            $callableAction = $entityConfig->getAction($action);
        } catch (\Exception $e) {
            throw $this->createNotFoundException(
                sprintf(
                    'Action "%s" for entity "%s" not found, did you registered it in the config?',
                    $action,
                    $entity
                )
            );
        }

        return $callableAction->execute($entityObject, $entityConfig, $request);
    }
}
