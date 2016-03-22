<?php

namespace LIN3S\AdminBundle\Controller;

use LIN3S\AdminBundle\Annotation\EntityConfiguration;
use LIN3S\AdminBundle\Configuration\EntityConfigurationInterface;
use LIN3S\AdminBundle\Event\EditEvent;
use LIN3S\AdminBundle\LIN3SAdminEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @EntityConfiguration()
     * @Template()
     *
     * @param EntityConfigurationInterface $entityConfig
     *
     * @return array
     */
    public function listAction($entity, EntityConfigurationInterface $entityConfig, Request $request)
    {
        $entities = $this->get('lin3s_admin.repository')->findByRequest($request, $entityConfig);
        $totalCount = $this->get('lin3s_admin.repository')->countAll($entityConfig);
        $actionRegistry = $this->get('lin3s_admin.action.registry');
        $batchActions = [];
        $entityActions = [];

        foreach ($entityConfig->listBatchActions() as $action) {
            $batchActions[] = $actionRegistry->get($action);
        }

        foreach ($entityConfig->listEntityActions() as $action) {
            $entityActions[] = $actionRegistry->get($action);
        }

        return [
            "entities"      => $entities,
            "entityConfig"  => $entityConfig,
            "totalCount"    => $totalCount,
            "batchActions"  => $batchActions,
            "entityActions" => $entityActions,
        ];
    }

    /**
     * @EntityConfiguration()
     * @Template()
     *
     * @param EntityConfigurationInterface $entityConfig
     * @param Request                      $request
     *
     * @return array
     */
    public function newAction($entity, EntityConfigurationInterface $entityConfig, Request $request)
    {
        $form = $this->get('lin3s_admin.form.handler')->handleForm(
            $entityConfig->form(), null, $request
        );

        if ($form->isValid()) {
            $this->addFlash(
                'lin3s_admin_success',
                sprintf('%s created successfully', $entityConfig->name())
            );

            return $this->redirect($this->generateUrl('lin3s_admin_edit', [
                'entity' => $entityConfig->name(), 'id' => $form->getData()->id(),
            ]));
        } else if($form->isSubmitted()) {
            $this->addFlash(
                'lin3s_admin_error',
                sprintf('Errors while saving %s. Please check all fields and try again', $entityConfig->name())
            );
        }

        return [
            'entity'       => $entity,
            'entityConfig' => $entityConfig,
            'form'         => $form->createView(),
        ];
    }

    /**
     * @EntityConfiguration()
     * @Template()
     *
     * @param mixed                        $id The id of the object to be edited.
     * @param EntityConfigurationInterface $entityConfig
     * @param Request                      $request
     *
     * @return array Parameters that will be used to render the template
     */
    public function editAction($entity, $id, EntityConfigurationInterface $entityConfig, Request $request)
    {
        $manager = $this->getDoctrine()->getRepository($entityConfig->className());

        $entity = $manager->findOneBy([$entityConfig->idField() => $id]);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $this->get('event_dispatcher')->dispatch(
            LIN3SAdminEvents::EDIT_INITIALIZE,
            new EditEvent($request, $entity)
        );

        $form = $this->get('lin3s_admin.form.handler')->handleForm(
            $entityConfig->form(), $entity, $request
        );

        if ($form->isValid()) {
            $this->addFlash(
                'lin3s_admin_success',
                sprintf('%s edited successfully', $entityConfig->name())
            );
        } else if($form->isSubmitted()) {
            $this->addFlash(
                'lin3s_admin_error',
                sprintf('Errors while saving %s. Please check all fields and try again', $entityConfig->name())
            );
        }

        return [
            'entity'       => $entity,
            'entityConfig' => $entityConfig,
            'form'         => $form->createView(),
        ];
    }

    /**
     * @EntityConfiguration()
     *
     * @param string                       $id     The id of the object to be edited.
     * @param string                       $action The action to be executed
     * @param EntityConfigurationInterface $entityConfig
     *
     * @return array Parameters that will be used to render the template
     */
    public function batchAction($entity, $id, $action, EntityConfigurationInterface $entityConfig)
    {
        $manager = $this->getDoctrine()->getRepository($entityConfig->className());

        $entity = $manager->findOneBy([$entityConfig->idField() => $id]);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $actionRegistry = $this->get('lin3s_admin.action.registry');
        $response = $actionRegistry->get($action)->execute($entity, $entityConfig);

        if (!$response instanceof RedirectResponse) {
            throw new \InvalidArgumentException;
        }

        return $response;
    }

    public function searchAction()
    {

    }
}
