<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Repository;

use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use Symfony\Component\HttpFoundation\Request;

interface QueryBuilder
{
    /**
     * Generates a doctrine query builder with the required order,
     * filter and associations for the given request and entity configuration.
     *
     * @param Request             $request The request with filter, order and pagination parameters
     * @param EntityConfiguration $config  The entity configuration
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function generate(Request $request, EntityConfiguration $config);
}
