<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFields\Types;

use LIN3S\AdminBundle\ListFields\ListFieldType;

/**
 * Date list field type.
 *
 * @author Jagoba Perez <jagoba@lin3s.com>
 */
class DateListFieldType implements ListFieldType
{
    /**
     * {@inheritdoc}
     */
    public function render($entity, $options)
    {
        if (!isset($options['field'])) {
            throw new \InvalidArgumentException('Field to be rendered must be passed as string');
        }
        $properties = explode('.', $options['field']);

        $value = $entity;
        foreach ($properties as $property) {
            $value = $value->$property();
        }
        if (!$value instanceof \DateTimeInterface) {
            throw new \Exception(sprintf('%s must implement the \DateTimeInterface', $value));
        }

        return $value->format('d M Y');
    }
}
