<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFilters;

class ListFilter
{
    private $name;

    /**
     * @var ListFilterType
     */
    private $type;

    private $field;

    public function __construct($name, ListFilterType $type, $field)
    {
        $this->name = $name;
        $this->type = $type;
        $this->field = $field;
    }

    public function name()
    {
        return $this->name;
    }

    public function field()
    {
        return $this->field;
    }

    public function type()
    {
        return $this->type;
    }
}
