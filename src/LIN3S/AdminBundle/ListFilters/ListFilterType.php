<?php

namespace LIN3S\AdminBundle\ListFilters;

interface ListFilterType
{
    public function render(ListFilter $filter, $currentValue, $options);
}
