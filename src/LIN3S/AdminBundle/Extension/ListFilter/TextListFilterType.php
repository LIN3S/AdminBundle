<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Extension\ListFilter;

use LIN3S\AdminBundle\Configuration\Model\ListFilter;
use LIN3S\AdminBundle\Configuration\Type\ListFilterType;

/**
 * Text list filter field type.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class TextListFilterType implements ListFilterType
{
    public function render(ListFilter $filter, $currentValue, $options)
    {
        $attributes = $currentValue !== null ? ' value="' . $currentValue . '"' : '';

        foreach ($options['attrs'] as $attrName => $attr) {
            $attributes .= ' ' . $attrName . '="' . $attr . '"';
        }

        return sprintf('<input %s type="text" data-filter-field="%s">', $attributes, $filter->field());
    }
}
