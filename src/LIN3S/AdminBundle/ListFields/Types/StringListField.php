<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFields\Types;

class StringListField
{
    protected $field;

    private $name;

    public function __construct($field, $name)
    {
        $this->field = $field;
        $this->name = $name;
    }

    public function field() {
        return $this->field;
    }

    public function name()
    {
        return $this->name;
    }

    public function toString($entity)
    {
        $properties = explode('.', $this->field);

        $value = $entity;
        foreach($properties as $property) {
            $value = $value->$property();
        }

        return $value;
    }
}
