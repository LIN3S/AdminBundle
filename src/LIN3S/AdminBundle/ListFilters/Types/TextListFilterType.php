<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFilters\Types;

use LIN3S\AdminBundle\ListFilters\ListFilter;
use LIN3S\AdminBundle\ListFilters\ListFilterType;

class TextListFilterType implements ListFilterType
{
    public function render(ListFilter $filter, $currentValue, $options)
    {
        $attrs = $currentValue !== null ? ' value="' . $currentValue . '"' : '';

        foreach ($options['attrs'] as $attrName => $attr) {
            $attrs .= ' ' . $attrName . '="' . $attr . '"';
        }

        return
            sprintf(
                '<input %s type="text" data-filter-field="%s">',
                $attrs,
                $filter->field()
            );
    }
}
