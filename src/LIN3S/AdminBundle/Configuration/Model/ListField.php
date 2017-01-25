<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Model;

use LIN3S\AdminBundle\Configuration\Type\ListFieldType;

/**
 * List field.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ListField
{
    /**
     * The field name.
     *
     * @var string
     */
    private $name;

    /**
     * Array which contains options.
     *
     * @var array
     */
    private $options;

    /**
     * The field type.
     *
     * @var ListFieldType
     */
    private $type;

    /**
     * ListField constructor.
     *
     * @param string        $name    The field name
     * @param ListFieldType $type    The field type
     * @param array         $options Array which contains options
     */
    public function __construct($name, ListFieldType $type, array $options = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * Gets the field name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Gets the options.
     *
     * @return array
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Gets the field type.
     *
     * @return ListFieldType
     */
    public function type()
    {
        return $this->type;
    }
}
