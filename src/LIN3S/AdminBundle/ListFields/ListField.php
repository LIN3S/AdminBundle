<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\ListFields;

class ListField
{
    private $name;

    /**
     * @var ListFieldType
     */
    private $type;

    private $options;

    public function __construct($name, ListFieldType $type, $options)
    {
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }

    public function name()
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }

    public function options()
    {
        return $this->options;
    }
}
