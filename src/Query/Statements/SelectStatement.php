<?php

namespace SimpleDataBaseOrm\Query\Statements;

use SimpleDataBaseOrm\Connectors\Adapters\ConnectionInterface;
use SimpleDataBaseOrm\Query\Clauses\LimitClause;
use SimpleDataBaseOrm\Query\Clauses\OrderClause;
use SimpleDataBaseOrm\Query\Clauses\WhereClause;
use SimpleDataBaseOrm\Query\Exceptions\StatementInvalidArgumentException;
use SimpleDataBaseOrm\Query\Statements\Traits\AttachLimitClauseTrait;
use SimpleDataBaseOrm\Query\Statements\Traits\AttachOrderClauseTrait;
use SimpleDataBaseOrm\Query\Statements\Traits\AttachWhereClauseTrait;

class SelectStatement extends Statement
{
    use AttachWhereClauseTrait, AttachOrderClauseTrait, AttachLimitClauseTrait;

    protected $columns = ['*'];

    public function __construct(ConnectionInterface $connection, array $columns = [])
    {
        parent::__construct($connection);

        if (!empty($columns)) $this->columns = $columns;
    }

    /**
     * Init used clauses by statements
     */
    protected function initClauses()
    {
        $this->whereClause = new WhereClause();

        $this->orderClause = new OrderClause();

        $this->limitClause = new LimitClause();
    }

    public function from($table)
    {
        return $this->table($table);
    }

    /**
     * @return string
     */

    public function __toString()
    {
        if (empty($this->table))
        {
            throw new StatementInvalidArgumentException('No table is set for selection');
        }

        $statement = sprintf(
            "SELECT %s FROM `%s` %s %s %s",
            implode(', ', $this->parseColumns()),
            $this->table,
            $this->whereClause,
            $this->orderClause,
            $this->limitClause
        );

        return $statement;
    }
}