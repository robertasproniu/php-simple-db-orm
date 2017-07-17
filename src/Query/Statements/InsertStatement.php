<?php

namespace SimpleDataBaseOrm\Query\Statements;


use SimpleDataBaseOrm\Connectors\Adapters\ConnectionInterface;
use SimpleDataBaseOrm\Query\Exceptions\ClauseInvalidArgumentException;
use SimpleDataBaseOrm\Query\Exceptions\StatementInvalidArgumentException;
use InvalidArgumentException;

class InsertStatement extends Statement
{
    protected $columns = [];

    protected $fetch = false;

    public function __construct(ConnectionInterface $connection, array $columns)
    {
        parent::__construct($connection);

        $this->columns = $columns;
    }

    private function parseValues()
    {
        $totalValues = count($this->values);

        if (count($this->columns) != $totalValues)
        {
            throw new InvalidArgumentException("Number of values don't match with no of columns");
        }

        $placeholders = array_fill(0, $totalValues ? $totalValues : 1, '?');

        return implode(', ', $placeholders);
    }

    public function into($table)
    {
        return $this->table($table);
    }

    public function values(array $values = [])
    {
        if (empty($values))
        {
            throw new ClauseInvalidArgumentException("Insert should have at least one value");
        }

        $this->values = $values;

        return $this;
    }

    /**
     * @return array
     */
    public function execute()
    {
        parent::execute();

        $id = $this->connection->id();

        return $id ? [ $id ] : [];
    }

    public function __toString()
    {
        if (empty($this->table))
        {
            throw new StatementInvalidArgumentException('No table was set');
        }

        if (empty($this->columns))
        {
            throw new InvalidArgumentException("No values were sent for insertion");
        }

        if (empty($this->values))
        {
            throw new InvalidArgumentException("No values were sent for insertion");
        }

        $statement = sprintf(
            "INSERT INTO `%s` (%s) VALUES (%s)",
            $this->table,
            implode(', ', $this->parseColumns()),
            $this->parseValues()
        );

        return $statement;
    }
}