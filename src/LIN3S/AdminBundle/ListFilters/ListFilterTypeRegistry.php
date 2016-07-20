<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFilters;

/**
 * List filter type registry.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ListFilterTypeRegistry
{
    /**
     * Array which contains filters.
     *
     * @var ListFilterType[]
     */
    protected $filters;

    /**
     * Constructor.
     *
     * @param array $filters The filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Adds the given action inside collection of list filter types.
     *
     * @param ListFilterType $listFilterType The list filter type
     */
    public function add(ListFilterType $listFilterType)
    {
        if (isset($this->filters[get_class($listFilterType)])) {
            throw new \InvalidArgumentException(
                sprintf('Class %s already registered in filter type list', get_class($listFilterType))
            );
        }

        $this->filters[get_class($listFilterType)] = $listFilterType;
    }

    /**
     * Gets the list filter of class name given.
     *
     * @param string $className The class name
     *
     * @return ListFilterType
     */
    public function get($className)
    {
        if (!isset($this->filters[$className])) {
            throw new \InvalidArgumentException(
                sprintf('No list filter type registered for class %s.', $className)
            );
        }

        return $this->filters[$className];
    }
}
