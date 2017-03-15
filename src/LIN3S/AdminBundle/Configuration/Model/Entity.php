<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Model;

use LIN3S\AdminBundle\Repository\QueryBuilder;

/**
 * Entity configuration.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
final class Entity
{
    /**
     * Collection of actions.
     *
     * @var array
     */
    protected $actions;

    /**
     * The entity name.
     *
     * @var string
     */
    protected $name;

    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The list actions.
     *
     * @var array
     */
    protected $listActions;

    /**
     * The list fields.
     *
     * @var array
     */
    protected $listFields;

    /**
     * The list filters.
     *
     * @var array
     */
    protected $listFilters;

    /**
     * The entities per page.
     *
     * @var int
     */
    protected $listEntitiesPerPage;

    /**
     * The list global actions.
     *
     * @var array
     */
    protected $listGlobalActions;

    /**
     * The list order by default.
     *
     * @var array
     */
    protected $listOrderByDefault;

    /**
     * The entity name, for visualization purposes.
     *
     * It contains the singular and plural cases.
     *
     * @var array
     */
    private $printNames;

    /**
     * The query builder.
     *
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * EntityConfiguration constructor.
     *
     * @param string       $name                The entity name
     * @param string       $className           The class name
     * @param array        $actions             Collection of actions
     * @param array        $listActions         List actions
     * @param array        $listFields          List fields
     * @param array        $listFilters         List filters
     * @param array        $listGlobalActions   List global actions
     * @param QueryBuilder $queryBuilder        The query builder
     * @param array        $printNames          The entity name, for visualization purposes
     * @param int          $listEntitiesPerPage The number of entities per page
     * @param array        $listOrderByDefault  The order by default
     */
    public function __construct(
        $name,
        $className,
        array $actions,
        array $listActions = [],
        array $listFields = [],
        array $listFilters = [],
        array $listGlobalActions = [],
        QueryBuilder $queryBuilder,
        array $printNames,
        $listEntitiesPerPage,
        array $listOrderByDefault = []
    ) {
        $this->name = $name;
        $this->className = $className;
        $this->actions = $actions;
        $this->listFields = $listFields;
        $this->listFilters = $listFilters;
        $this->actions = $actions;
        $this->listActions = $listActions;
        $this->listGlobalActions = $listGlobalActions;
        $this->queryBuilder = $queryBuilder;
        $this->printNames = $printNames;
        $this->listEntitiesPerPage = $listEntitiesPerPage;
        $this->listOrderByDefault = $listOrderByDefault;

        foreach ($listFields as $field) {
            if (!$field instanceof ListField) {
                throw new \InvalidArgumentException('List fields must implement ListField interface');
            }
        }
        foreach ($listFilters as $filter) {
            if (!$filter instanceof ListFilter) {
                throw new \InvalidArgumentException('List filters must implement ListFilter interface');
            }
        }
        foreach ($actions as $action) {
            if (!$action instanceof Action) {
                throw new \InvalidArgumentException('Actions must implement Action interface');
            }
        }
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
    }

    /**
     * Gets the id of the given entity.
     *
     * @param mixed $entity The entity
     *
     * @return mixed The entity id
     * @throws \Exception when the id does not exist
     */
    public function id($entity)
    {
        $idField = $this->idField();

        if (method_exists($entity, $idField)) {
            return call_user_func([$entity, $idField]);
        } elseif (method_exists($entity, 'get' . ucfirst($idField))) {
            return call_user_func([$entity, 'get' . ucfirst($idField)]);
        }

        throw new \Exception(
            sprintf(
                'You have configured "%s" as id field, not %s public property found nor %s() ' .
                'nor, get%s() methods found', $idField, $idField, $idField, ucfirst($idField)
            )
        );
    }

    /**
     * Gets the entity name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Gets the class name.
     *
     * @return string
     */
    public function className()
    {
        return $this->className;
    }

    /**
     * Gets the id field of the entity.
     *
     * @return string
     */
    public function idField()
    {
        return 'id';
    }

    /**
     * Gets the actions.
     *
     * @return array
     */
    public function actions()
    {
        return $this->actions;
    }

    /**
     * Gets the action of the name given.
     *
     * @param string $name The action name
     *
     * @throws \InvalidArgumentException when the given action not found in the entity
     *
     * @return Action
     */
    public function getAction($name)
    {
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
     * Gets the number of entities per page.
     *
     * @return int
     */
    public function listEntitiesPerPage()
    {
        return $this->listEntitiesPerPage;
    }

    /**
     * Gets the order by default.
     *
     * @return array
     */
    public function listOrderByDefault()
    {
        return $this->listOrderByDefault;
    }

    /**
     * Gets the fields.
     *
     * @return array
     */
    public function listFields()
    {
        return $this->listFields;
    }

    /**
     * Gets the actions.
     *
     * @return array
     */
    public function listActions()
    {
        $listActions = [];

        foreach ($this->listActions as $listAction) {
            $listActions[] = $this->getAction($listAction);
        }

        return $listActions;
    }

    /**
     * Gets the filters.
     *
     * @return array
     */
    public function listFilters()
    {
        return $this->listFilters;
    }

    /**
     * Gets the batch actions.
     *
     * @return array
     */
    public function listBatchActions()
    {
        return [];
    }

    /**
     * Gets the global actions.
     *
     * @return array
     */
    public function listGlobalActions()
    {
        $listGlobalActions = [];

        foreach ($this->listGlobalActions as $listGlobalAction) {
            $listGlobalActions[] = $this->getAction($listGlobalAction);
        }

        return $listGlobalActions;
    }

    /**
     * Gets the print names.
     *
     * @return array
     */
    public function printNames()
    {
        return $this->printNames;
    }

    /**
     * Gets the query builder.
     *
     * @return QueryBuilder
     */
    public function queryBuilder()
    {
        return $this->queryBuilder;
    }
}
