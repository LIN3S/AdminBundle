<?php

/*
 * This file is part of the Denbolan project.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Repository;

use Doctrine\ORM\EntityManager;
use LIN3S\AdminBundle\Configuration\EntityConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminRepository
{
    protected $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function findByRequest(Request $request, EntityConfigurationInterface $config) {
        $postPerPage = $config->listEntitiesPerPage();
        $orderBy = $request->get('orderBy') ? [
            $request->get('orderBy') => $request->get('order', 'ASC')
        ] : null;
        $offset = ($request->get('page', 1) - 1) * $postPerPage;
        $limit = $postPerPage;

        return $this->manager->getRepository($config->className())
            ->findBy([], $orderBy, $limit, $offset);
    }

    public function countAll(EntityConfigurationInterface $config) {
        $qb = $this->manager->createQueryBuilder();

        $qb->select($qb->expr()->count('e'))
            ->from($config->className(), 'e');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
