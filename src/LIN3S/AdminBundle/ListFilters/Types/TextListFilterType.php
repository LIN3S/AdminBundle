<?php

namespace LIN3S\AdminBundle\ListFilters\Types;

use LIN3S\AdminBundle\ListFilters\ListFilter;
use LIN3S\AdminBundle\ListFilters\ListFilterType;

class TextListFilterType implements ListFilterType
{
    public function render(ListFilter $filter, $currentValue, $options)
    {
        $attrs = $currentValue != null ? ' value="' . $currentValue . '"' : '';

        foreach($options['attrs'] as $attrName => $attr) {
            $attrs .= " " . $attrName . '="' . $attr . '"';
        }
        return
            sprintf(
                '<input %s type="text" data-filter-field="%s">',
                $attrs,
                $filter->field()
            );
    }
}
