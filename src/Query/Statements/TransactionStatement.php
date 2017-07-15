<?php

namespace SimpleDataBaseOrm\Query\Statements;


use SimpleDataBaseOrm\Connectors\Adapters\ConnectionInterface;
use SimpleDataBaseOrm\Database;
use Closure;

class TransactionStatement extends Statement
{
    /**
     * @var
     */
    private $database;

    /**
     * @var
     */
    private $callback;

    public function __construct(Database $database, ConnectionInterface $connection, Closure $callback)
    {
        parent::__construct($connection);

        $this->database = $database;

        $this->callback = $callback;

        $this->connection->transaction( function () {
            return call_user_func($this->callback, $this->database);
        } );
    }

    public function __toString()
    {
        return '';
    }
}