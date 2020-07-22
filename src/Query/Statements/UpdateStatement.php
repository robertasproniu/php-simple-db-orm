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

class UpdateStatement extends Statement
{
    use AttachWhereClauseTrait, AttachLimitClauseTrait, AttachOrderClauseTrait;

    protected $fetch = false;

    protected $columns = [];

    public function __construct(ConnectionInterface $connection, array $params = [])
    {
        parent::__construct($connection);

        $this->set($params);
    }

    private function parseParams($params)
    {
        // invalidate if is not associative array
        if (count($params) != count($params, COUNT_RECURSIVE))
        {
            throw new InvalidArgumentException("Update parameter should be associative array. Eg. [ 'column' => 'value' ] ");
        }

        $this->columns = array_keys($params);

        $this->values = array_values($params);
    }

    protected function parseColumns()
    {
        $columns = parent::parseColumns();

        return count($columns) > 1
            ? $this->prepareValues($columns) /*implode(' = ? , ', $columns)*/
            : sprintf("%s  = ? ", array_shift($columns));
    }

    public function prepareValues(array $columns){
        return implode(' = ? , ', $columns)." = ? ";
    }

    public function table($table)
    {
        return parent::table($table);
    }

    public function set(array $params)
    {
        $this->parseParams($params);

        return $this;
    }

    /**
     * Execute query and return no of rows
     *
     * @return array
     */
    public function execute()
    {
        parent::execute();

        $rows = $this->connection->rows();

        return $rows ? [$rows] : [];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table))
        {
            throw new InvalidArgumentException('No table is set for update');
        }

        return sprintf(
            "UPDATE %s SET %s %s %s %s",
            $this->table,
            $this->parseColumns(),
            $this->whereClause,
            $this->orderClause,
            $this->limitClause
        );
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
}