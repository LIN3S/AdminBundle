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

/**
 * @author Beña Espiña <benatespina@gmail.com>
 */
class AdminRepositoryFactory
{
    private $repositories;

    public function __construct($repositories)
    {
        $this->repositories = $repositories;
    }

    public function build($strategy)
    {
        if (!array_key_exists($strategy, $this->repositories)) {
            throw new AdminRepositoryStrategyDoesNotExist();
        }

        return $this->repositories[$strategy];
    }
}
