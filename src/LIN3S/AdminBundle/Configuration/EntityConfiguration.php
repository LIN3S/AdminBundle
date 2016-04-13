<?php
/*
 * This file is part of the extranet project.
 *
 * (c) gorka
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration;

use LIN3S\AdminBundle\Action\Action;
use LIN3S\AdminBundle\ListFields\ListField;

class EntityConfiguration
{
    protected $actions;
    protected $name;
    protected $className;
    protected $listActions = [];
    protected $listFields = [];
    protected $listEntitiesPerPage = 10;
    protected $listOrderByDefault = [];

    public function __construct($name, $className, $actions, $listActions, $listFields)
    {
        $this->name = $name;
        $this->className = $className;
        $this->actions = $actions;

        foreach ($listFields as $field) {
            if (!$field instanceof ListField) {
                throw new \InvalidArgumentException('List fields must extend ListField interface');
            }
        }

        $this->listFields = $listFields;

        foreach ($actions as $action) {
            if (!$action instanceof Action) {
                throw new \InvalidArgumentException('Actions must extend Action interface');
            }
        }

        $this->actions = $actions;

        foreach ($listActions as $listAction) {
            try {
                $this->getAction($listAction);
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'List action "%s is not registered for entity "%s". Make sure you add it in the actions array
                        before adding it to the list field array',
                        $listAction,
                        $name
                    )
                );
            }
        }

        $this->listActions = $listActions;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function className()
    {
        return $this->className;
    }

    public function idField()
    {
        return 'id';
    }

    /**
     * @return mixed
     */
    public function actions()
    {
        return $this->actions;
    }

    public function getAction($name)
    {
        /**
         * @var Action $action
         */
        foreach ($this->actions as $action) {
            if ($action->name() == $name) {
                return $action;
            }
        }

        throw new \InvalidArgumentException(
            sprintf('Action "%s" not found for "%s" entity', $name, $this->name)
        );
    }

    /**
     * @return int
     */
    public function listEntitiesPerPage()
    {
        return $this->listEntitiesPerPage;
    }

    /**
     * @return array
     */
    public function listOrderByDefault()
    {
        return $this->listOrderByDefault;
    }

    /**
     * @return array
     */
    public function listFields()
    {
        return $this->listFields;
    }

    public function listActions()
    {
        $listActions = [];

        foreach($this->listActions as $listAction) {
            $listActions[] = $this->getAction($listAction);
        }

        return $listActions;
    }

    public function listBatchActions()
    {
        return [];
    }
}
