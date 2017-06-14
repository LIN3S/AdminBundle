<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Factory;

use LIN3S\AdminBundle\Configuration\Model\Action;
use LIN3S\AdminBundle\Configuration\Model\Entity;
use LIN3S\AdminBundle\Configuration\Model\ListField;
use LIN3S\AdminBundle\Configuration\Model\ListFilter;
use LIN3S\AdminBundle\Registry\ServiceRegistry;
use LIN3S\AdminBundle\Repository\QueryBuilder;

final class EntityConfigurationFactory
{
    private $config;
    private $actions;
    private $listFields;
    private $listFilters;
    private $queryBuilder;

    public function __construct(
        $config,
        ServiceRegistry $actions,
        ServiceRegistry $listFields,
        ServiceRegistry $listFilters,
        QueryBuilder $queryBuilder
    ) {
        $this->config = $config['entities'];
        $this->actions = $actions;
        $this->listFields = $listFields;
        $this->listFilters = $listFilters;
        $this->queryBuilder = $queryBuilder;
    }

    public function createFor($entity)
    {
        $entityConfig = $this->config[$entity];

        return new Entity(
            $entity,
            $entityConfig['class'],
            $this->actionsForEntity($entity),
            $entityConfig['list']['actions'],
            $this->listFieldsForEntity($entity),
            $this->listFiltersForEntity($entity),
            $entityConfig['list']['global_actions'],
            $this->queryBuilder,
            $entityConfig['name'],
            $entityConfig['list']['amount_per_page'],
            $entityConfig['list']['order_by']
        );
    }

    private function actionsForEntity($entity)
    {
        $actions = [];

        foreach ($this->config[$entity]['actions'] as $id => $action) {
            $actions[] = new Action(
                $id,
                $this->actions->get($action['type']),
                $action['options']
            );
        }

        return $actions;
    }

    private function listFieldsForEntity($entity)
    {
        $listFields = [];

        foreach ($this->config[$entity]['list']['fields'] as $id => $field) {
            $listFields[] = new ListField(
                isset($field['name']) ? $field['name'] : $id,
                $this->listFields->get($field['type']),
                $field['options']
            );
        }

        return $listFields;
    }

    private function listFiltersForEntity($entity)
    {
        $listFilters = [];

        foreach ($this->config[$entity]['list']['filters'] as $id => $filter) {
            $listFilters[] = new ListFilter(
                isset($filter['name']) ? $filter['name'] : $id,
                $this->listFilters->get($filter['type']),
                $filter['field']
            );
        }

        return $listFilters;
    }
}
