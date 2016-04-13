<?php

namespace LIN3S\AdminBundle\ListFields;

class ListField
{
    private $name;

    /**
     * @var ListFieldType
     */
    private $type;

    private $options;

    public function __construct($name, ListFieldType $type, $options)
    {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }

    public function name()
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }

    public function options()
    {
        return $this->options;
    }
}
