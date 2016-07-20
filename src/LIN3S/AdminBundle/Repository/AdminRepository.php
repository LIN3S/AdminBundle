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

/**
 * Admin repository.
 *
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class AdminRepository
{
    /**
     * Finds the result about request criteria and given entity configuration.
     *
     * @param Request             $request The request
     * @param EntityConfiguration $config  The entity configuration
     *
     * @return array
     */
    public function findByRequest(Request $request, EntityConfiguration $config)
    {
        $queryBuilder = $config->queryBuilder()->generate($request, $config);

        $postPerPage = $config->listEntitiesPerPage();

        $offset = ($request->get('page', 1) - 1) * $postPerPage;
        $limit = $postPerPage;

        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Counts all the result about request criteria and given entity configuration.
     *
     * @param Request             $request The request
     * @param EntityConfiguration $config  The entity configuration
     *
     * @return int
     */
    public function countAll(Request $request, EntityConfiguration $config)
    {
        $queryBuilder = $config->queryBuilder()->generate($request, $config);
        $queryBuilder->select($queryBuilder->expr()->count('a'));

        return count($queryBuilder->getQuery()->getScalarResult());
    }
}
