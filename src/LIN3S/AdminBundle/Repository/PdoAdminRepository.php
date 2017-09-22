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

use LIN3S\AdminBundle\Configuration\Model\Entity;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class PdoAdminRepository implements AdminRepository
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find(Entity $config, $id)
    {
        // TODO: Implement find() method.
    }

    public function findByRequest(Request $request, Entity $config)
    {
    }

    public function countAll(Request $request, Entity $config)
    {
    }
}
