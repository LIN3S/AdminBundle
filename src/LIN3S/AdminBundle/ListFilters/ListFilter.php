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

/**
 * List filter.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ListFilter
{
    /**
     * The name.
     *
     * @var string
     */
    private $name;

    /**
     * The type.
     *
     * @var ListFilterType
     */
    private $type;

    /**
     * The field name.
     *
     * @var string
     */
    private $field;

    /**
     * ListFilter constructor.
     *
     * @param string         $name  The name
     * @param ListFilterType $type  The type
     * @param string         $field The field name
     */
    public function __construct($name, ListFilterType $type, $field)
    {
        $this->name = $name;
        $this->type = $type;
        $this->field = $field;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Gets the field.
     *
     * @return string
     */
    public function field()
    {
        return $this->field;
    }

    /**
     * Gets the type.
     *
     * @return ListFilterType
     */
    public function type()
    {
        return $this->type;
    }
}
