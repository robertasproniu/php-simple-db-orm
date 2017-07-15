<?php

namespace SimpleDataBaseOrm\Connectors;

class MySqlConnector extends Connector
{
    function connect($config)
    {
        return $this->createConnection($this->getDns($config), $config, $this->options);
    }

    private function getDns($config)
    {
        extract($config);

        return isset($config['port'])
            ? "mysql:host={$hostname};port={$port};dbname={$database}"
            : "mysql:host={$hostname};dbname={$database}";
    }
}