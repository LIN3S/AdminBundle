<?php

/*
 * This file is part of the Admin Bundle.
 *
 * Copyright (c) 2015-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\AdminBundle\Repository;

use Doctrine\ORM\EntityManager;
use LIN3S\AdminBundle\Configuration\Model\Entity;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class DoctrineAdminRepository implements AdminRepository
{
    private $manager;
    private $queryBuilder;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->queryBuilder = new DoctrineQueryBuilder($this->manager);
    }

    public function find(Entity $config, $id)
    {
        return $this->manager->find($config->className(), $id);
    }

    public function remove($entity)
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }

    public function findByRequest(Request $request, Entity $config)
    {
        $queryBuilder = $this->queryBuilder->generate($request, $config);

        $postPerPage = $config->listEntitiesPerPage();

        $offset = ($request->get('page', 1) - 1) * $postPerPage;
        $limit = $postPerPage;

        $queryBuilder->setFirstResult($offset);
        $queryBuilder->setMaxResults($limit);

        return $queryBuilder->getQuery()->getResult();
    }

    public function countAll(Request $request, Entity $config)
    {
        $queryBuilder = $this->queryBuilder->generate($request, $config);
        $queryBuilder->select($queryBuilder->expr()->count('a'));

        return count($queryBuilder->getQuery()->getScalarResult());
    }
}
