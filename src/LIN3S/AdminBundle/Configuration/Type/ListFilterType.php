<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Configuration\Type;

use LIN3S\AdminBundle\Configuration\Model\ListFilter;

/**
 * List filter type.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
interface ListFilterType
{
    /**
     * Methods that renders the field type with the given params.
     *
     * @param ListFilter $filter       The filter
     * @param string     $currentValue The value
     * @param array      $options      Array which contains options
     *
     * @return mixed
     */
    public function render(ListFilter $filter, $currentValue, $options);
}
