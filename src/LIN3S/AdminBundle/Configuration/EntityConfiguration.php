<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration;

use LIN3S\AdminBundle\Action\Action;
use LIN3S\AdminBundle\ListFields\ListField;
use LIN3S\AdminBundle\ListFilters\ListFilter;
use LIN3S\AdminBundle\Repository\QueryBuilder;

class EntityConfiguration
{
    protected $actions;
    protected $name;
    protected $className;
    protected $listActions = [];
    protected $listFields = [];
    protected $listFilters = [];
    protected $listEntitiesPerPage = 10;
    protected $listGlobalActions = [];
    protected $listOrderByDefault = [];
    protected $queryBuilder;

    public function __construct($name,
                                $className,
                                $actions,
                                $listActions,
                                $listFields,
                                $listFilters,
                                $listGlobalActions,
                                QueryBuilder $queryBuilder)
    {
        $this->name = $name;
        $this->className = $className;
        $this->actions = $actions;

        foreach ($listFields as $field) {
            if (!$field instanceof ListField) {
                throw new \InvalidArgumentException('List fields must implement ListField interface');
            }
        }

        $this->listFields = $listFields;

        foreach ($listFilters as $filter) {
            if (!$filter instanceof ListFilter) {
                throw new \InvalidArgumentException('List filters must implement ListFilter interface');
            }
        }

        $this->listFilters = $listFilters;

        foreach ($actions as $action) {
            if (!$action instanceof Action) {
                throw new \InvalidArgumentException('Actions must implement Action interface');
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

        foreach ($listGlobalActions as $listGlobalAction) {
            try {
                $this->getAction($listGlobalAction);
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'List global action "%s is not registered for entity "%s". Make sure you add it in the actions
                        array before adding it to the list field array',
                        $listGlobalAction,
                        $name
                    )
                );
            }
        }

        $this->listGlobalActions = $listGlobalActions;

        $this->queryBuilder = $queryBuilder;
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
        /*
         * @var Action
         */
        foreach ($this->actions as $action) {
            if ($action->name() === $name) {
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

        foreach ($this->listActions as $listAction) {
            $listActions[] = $this->getAction($listAction);
        }

        return $listActions;
    }

    public function listFilters()
    {
        return $this->listFilters;
    }

    public function listBatchActions()
    {
        return [];
    }

    public function listGlobalActions()
    {
        $listGlobalActions = [];

        foreach ($this->listGlobalActions as $listGlobalAction) {
            $listGlobalActions[] = $this->getAction($listGlobalAction);
        }

        return $listGlobalActions;
    }

    public function queryBuilder()
    {
        return $this->queryBuilder;
    }
}
