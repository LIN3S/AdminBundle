<?php

namespace LIN3S\AdminBundle\Repository;

use LIN3S\AdminBundle\Configuration\EntityConfiguration;
use Symfony\Component\HttpFoundation\Request;

interface QueryBuilder
{
    /**
     * Generates a doctrine query builder with the required order, filter and associations for the given request and
     * entity configuration.
     *
     * @param Request             $request The request with optional filter, order and pagination parameters
     * @param EntityConfiguration $config  The entity configuration
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function generate(Request $request, EntityConfiguration $config);
}
