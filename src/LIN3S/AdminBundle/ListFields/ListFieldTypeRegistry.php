<?php

namespace LIN3S\AdminBundle\ListFields;

class ListFieldTypeRegistry
{
    /**
     * @var ListFieldType[]
     */
    protected $actions = [];

    /**
     * @inheritdoc
     */
    public function add(ListFieldType $listFieldType)
    {
        if (isset($this->actions[get_class($listFieldType)])) {
            throw new \InvalidArgumentException(
                sprintf('Class %s already registered in field type list', get_class($listFieldType))
            );
        }

        $this->actions[get_class($listFieldType)] = $listFieldType;
    }

    /**
     * @return ListFieldType
     */
    public function get($className)
    {
        if (isset($this->actions[$className])) {
            return $this->actions[$className];
        }

        throw new \InvalidArgumentException(
            sprintf('No list field type registered for class %s.', $className)
        );
    }
}
