<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFields;

/**
 * List field type registry.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ListFieldTypeRegistry
{
    /**
     * Array which contains list fields.
     *
     * @var ListFieldType[]
     */
    protected $listFields;

    /**
     * Constructor.
     *
     * @param array $listFields Array which contains list fields
     */
    public function __construct(array $listFields = [])
    {
        $this->listFields = $listFields;
    }

    /**
     * Adds the given action inside collection of list field types.
     *
     * @param ListFieldType $listFieldType The list field type
     */
    public function add(ListFieldType $listFieldType)
    {
        if (isset($this->listFields[get_class($listFieldType)])) {
            throw new \InvalidArgumentException(
                sprintf('Class %s already registered in field type list', get_class($listFieldType))
            );
        }

        $this->listFields[get_class($listFieldType)] = $listFieldType;
    }

    /**
     * Gets the list field of class name given.
     *
     * @param string $className The class name
     *
     * @return ListFieldType
     */
    public function get($className)
    {
        if (isset($this->listFields[$className])) {
            return $this->listFields[$className];
        }

        throw new \InvalidArgumentException(
            sprintf('No list field type registered for class %s.', $className)
        );
    }
}
