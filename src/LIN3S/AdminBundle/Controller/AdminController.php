<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Controller;

use LIN3S\AdminBundle\Annotation\EntityConfiguration as EntityConfigurationAnnotation;
use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @EntityConfigurationAnnotation()
     * @Template()
     *
     * @param EntityConfiguration $entityConfig
     *
     * @return array
     */
    public function listAction($entity, EntityConfiguration $entityConfig, Request $request)
    {
        $entities = $this->get('lin3s_admin.repository')->findByRequest($request, $entityConfig);
        $totalCount = $this->get('lin3s_admin.repository')->countAll($request, $entityConfig);

        return [
            'entities'      => $entities,
            'entityConfig'  => $entityConfig,
            'totalCount'    => $totalCount,
        ];
    }

    /**
     * @EntityConfigurationAnnotation()
     *
     * @param mixed               $entity       The id of the object to be edited.
     * @param EntityConfiguration $entityConfig
     * @param Request             $request
     *
     * @return array Parameters that will be used to render the template
     */
    public function customAction($entity, $action, $id = null, EntityConfiguration $entityConfig, Request $request)
    {
        $entityObject = null;
        if ($id) {
            $manager = $this->getDoctrine()->getRepository($entityConfig->className());
            $entityObject = $manager->find($id);
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

    public function searchAction()
    {
    }
}
