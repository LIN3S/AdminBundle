<?php

namespace LIN3S\AdminBundle\ListFilters;

class ListFilterTypeRegistry
{
    /**
     * @var ListFilterType[]
     */
    protected $filters = [];

    /**
     * @inheritdoc
     */
    public function add(ListFilterType $listFilterType)
    {
        if(isset($this->filters[get_class($listFilterType)])) {
            throw new \InvalidArgumentException(
                sprintf('Class %s already registered in filter type list', get_class($listFilterType))
            );
        }

        $this->filters[get_class($listFilterType)] = $listFilterType;
    }

    /**
     * @return ListFilterType
     */
    public function get($className)
    {
        if (isset($this->filters[$className])) {
            return $this->filters[$className];
        }

        throw new \InvalidArgumentException(
            sprintf('No list filter type registered for class %s.', $className)
        );
    }
}
