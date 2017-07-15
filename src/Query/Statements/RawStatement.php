<?php

namespace SimpleDataBaseOrm\Query\Statements;

use SimpleDataBaseOrm\Connectors\Adapters\ConnectionInterface;

class RawStatement extends Statement
{
    private $statement;

    /**
     * RawStatement constructor.
     * @param ConnectionInterface $connection
     * @param string $statement
     * @param array $values
     */
    public function __construct(ConnectionInterface $connection, $statement, array $values = [])
    {
        parent::__construct($connection);

        $this->statement = $statement;

        $this->values = $values;
    }
    /**
     * @return string
     */

    public function __toString()
    {
        return $this->statement;
    }
}