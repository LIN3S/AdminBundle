<?php

namespace LIN3S\AdminBundle\ListFields\Types;

use LIN3S\AdminBundle\ListFields\ListFieldType;

class StringListFieldType implements ListFieldType
{
    public function render($entity, $options)
    {
        if(!isset($options['field'])) {
            throw new \InvalidArgumentException('Field to be rendered must be passed as string');
        }
        $properties = explode('.', $options['field']);

        $value = $entity;
        foreach($properties as $property) {
            $value = $value->$property();
        }

        return $value;
    }
}
