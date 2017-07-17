<?php

namespace SimpleDataBaseOrm\Query\Statements;


use SimpleDataBaseOrm\Connectors\Adapters\ConnectionInterface;
use SimpleDataBaseOrm\Query\Clauses\LimitClause;
use SimpleDataBaseOrm\Query\Clauses\OrderClause;
use SimpleDataBaseOrm\Query\Clauses\WhereClause;
use SimpleDataBaseOrm\Query\Statements\Traits\AttachLimitClauseTrait;
use SimpleDataBaseOrm\Query\Statements\Traits\AttachOrderClauseTrait;
use SimpleDataBaseOrm\Query\Statements\Traits\AttachWhereClauseTrait;
use InvalidArgumentException;

class DeleteStatement extends Statement
{
    use AttachWhereClauseTrait, AttachLimitClauseTrait, AttachOrderClauseTrait;

    protected $fetch = false;

    protected function initClauses()
    {
        $this->whereClause = new WhereClause();

        $this->limitClause = new LimitClause();

        $this->orderClause = new OrderClause();
    }

    public function from($table)
    {
        return $this->table($table);
    }

    /**
     * Execute query
     *
     * @return array
     */

    public function execute()
    {
        parent::execute();

        $rows = $this->connection->rows();

        return $rows ? [ 'rows' => $rows ] : [];
    }

    public function __toString()
    {
        if (empty($this->table))
        {
            throw new InvalidArgumentException("No table specified");
        }

        return sprintf("DELETE FROM %s %s %s %s", $this->table, $this->whereClause, $this->orderClause, $this->limitClause);
    }
}