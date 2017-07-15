<?php

namespace SimpleDataBaseOrm;

use SimpleDataBaseOrm\Connectors\MySqlConnector;
use InvalidArgumentException;
use SimpleDataBaseOrm\Connectors\SqliteConnector;

class ConnectionFactory
{
    public function createConnection(array $config = [])
    {
        if ( ! isset($config['driver']) )
        {
            throw new InvalidArgumentException("A driver must be specified.");
        }

        switch ($config['driver'])
        {
            case 'mysql':
                return (new MySqlConnector)->connect($config);
            case 'sqlite':
                return (new SqliteConnector)->connect($config);
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}]");
    }
}