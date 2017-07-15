<?php
/**
 * Created by PhpStorm.
 * User: robert.aproniu
 * Date: 16/07/2017
 * Time: 02:21
 */

namespace SimpleDataBaseOrm\Connectors;


class SqliteConnector extends Connector
{

    public function connect($config)
    {
        return $this->createConnection($this->getDns($config), $config, $this->options);
    }

    protected function getDns($config)
    {
        return isset($config['database'])
            ? "sqlite:{$config['hostname']};dbname={$config['database']}"
            : "sqlite:{$config['hostname']}";
    }
}