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
 * @author Beñat Espiña <benatespina@gmail.com>
 */
final class ConnectionFactory
{
    private $driver;
    private $dbName;
    private $host;
    private $port;
    private $username;
    private $password;

    public function __construct($driver, $dbName, $host, $port, $username, $password)
    {
        $this->driver = $driver;
        $this->dbName = $dbName;
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    public function createConnection()
    {
        $dsn = sprintf('%s:dbname=%s;host=%s;port=%s', $this->driver, $this->dbName, $this->host, $this->port);

        return new \PDO($dsn, $this->username, $this->password);
    }
}
