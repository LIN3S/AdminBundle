<?php

namespace LIN3S\AdminBundle\ListFilters;

class ListFilter
{
    private $name;

    /**
     * @var ListFilterType
     */
    private $type;

    private $field;

    public function __construct($name, ListFilterType $type, $field)
    {
        $this->name = $name;
        $this->type = $type;
        $this->field = $field;
    }

    public function name()
    {
        return $this->name;
    }

    public function field()
    {
        return $this->field;
    }

    public function type()
    {
        return $this->type;
    }
}
