<?php

namespace SimpleDataBaseOrm\Connectors;

use SimpleDataBaseOrm\Connectors\Adapters\Pdo as PdoAdapter;
use PDO;

abstract class Connector
{
    protected $options = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    abstract public function connect($config);

    abstract protected function getDns($config);

    /**
     * Create a new connection to database
     * @param $dns
     * @param $config
     * @param $options
     * @return PdoAdapter
     */

    protected function createConnection($dns, $config, $options)
    {
        $username = isset($config['username']) ? $config['username'] : null;

        $password = isset($config['password']) ? $config['password'] : null;

        return new PdoAdapter(new PDO($dns, $username, $password, $options));
    }
}