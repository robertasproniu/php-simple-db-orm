<?php

namespace SimpleDataBaseOrm\Query\Statements;

use SimpleDataBaseOrm\Connectors\Adapters\ConnectionInterface;
use SimpleDataBaseOrm\Query\Clauses\LimitClause;
use SimpleDataBaseOrm\Query\Clauses\OrderClause;
use SimpleDataBaseOrm\Query\Clauses\WhereClause;

abstract class Statement
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    protected $table = null;

    /**
     * @var array
     */
    protected $columns = ['*'];

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var WhereClause null
     */
    protected $whereClause = null;

    /**
     * @var OrderClause null
     */
    protected $orderClause = null;

    /**
     * @var LimitClause null
     */
    protected $limitClause = null;

    /**
     * Allow fetch on execute or not
     *
     * @var bool true
     */
    protected $fetch = true;

    /**
     * Statement constructor.
     * @param ConnectionInterface $connection
     */

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;

        $this->initClauses();
    }

    /**
     * Convert statement to string
     *
     * @return string
     */
    abstract public function __toString();

    /**
     * Set table name
     *
     * @param $table
     * @return $this
     */
    protected function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * parseColumns for statements
     *
     * @return array
     */

    protected function parseColumns()
    {
        $columns = array_map(function ($column)
        {
            return trim($column) == "*"
                ? trim($column)
                : sprintf("`%s`", preg_replace('/\s+/', '', $column));
        }, $this->columns );

        return $columns;
    }

    /**
     * Init used clauses by statements
     */
    protected function initClauses() { }

    /**
     * Send query to driver to be executed
     *
     * @param $statement
     * @param array $values
     * @return mixed
     */
    final protected function query($statement, $values = [])
    {
        $results = [];

        $statement = preg_replace('/\s+/', ' ', $statement);

        $this->connection->query($statement, $values);

        if ($this->fetch)
        {
            $results = $this->connection->fetch();
        }

        return $results;
    }

    /**
     * Execute query
     *
     * @return array
     */
    public function execute()
    {
        return $this->query($this, $this->values);
    }
}