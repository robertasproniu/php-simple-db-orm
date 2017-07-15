<?php

namespace SimpleDataBaseOrm\Connectors;

class MySqlConnector extends Connector
{
    function connect($config)
    {
        return $this->createConnection($this->getDns($config), $config, $this->options);
    }

    protected function getDns($config)
    {
        return isset($config['port'])
            ? "mysql:host={$config['hostname']};port={$config['port']};dbname={$config['database']}"
            : "mysql:host={$config['hostname']};dbname={$config['database']}";
    }
}