<?php

namespace SimpleDataBaseOrm;

use SimpleDataBaseOrm\Query\Statements\DeleteStatement;
use SimpleDataBaseOrm\Query\Statements\InsertStatement;
use SimpleDataBaseOrm\Query\Statements\RawStatement;
use SimpleDataBaseOrm\Query\Statements\SelectStatement;
use SimpleDataBaseOrm\Query\Statements\TransactionStatement;
use SimpleDataBaseOrm\Query\Statements\UpdateStatement;
use InvalidArgumentException;
use Closure;

class Database
{
    /**
     * Store connections by name
     *
     * @var array
     */
    private $connections = [];

    private $currentConnection = null;

    /**
     * @var DatabaseConnection
     */
    private $connectionFactory;
    /**
     * @var DatabaseConfiguration
     */
    private $configuration;

    /**
     * Database constructor.
     * @param DatabaseConnection $connectionFactory
     * @param DatabaseConfiguration $configuration
     */
    public function __construct(DatabaseConnection $connectionFactory, DatabaseConfiguration $configuration)
    {
        $this->connectionFactory = $connectionFactory;

        $this->configuration = $configuration;

        $this->connection();
    }

    /**
     * Initialize Database connections by name
     *
     * @param null $name
     * @return $this
     */
    public function connection($name = null)
    {
        $name = $name ? $name : $this->configuration->get('default');

        if (! isset($this->connections[md5($name)]) )
        {
            $config = $this->configuration->get("connections.{$name}");

            $this->connections[md5($name)] = $this->connectionFactory->createConnection($config);
        }

        $this->currentConnection = $this->connections[md5($name)];

        return $this;
    }

    /**
     * Select rows
     *
     * @param array $columns
     * @return SelectStatement
     */
    public function select(array $columns = [])
    {
        return new SelectStatement($this->currentConnection, $columns);
    }

    /**
     * Insert rows
     *
     * @param array $columns
     * @return InsertStatement
     */

    public function insert(array $columns)
    {
        return new InsertStatement($this->currentConnection, $columns);
    }

    /**
     * Delete rows
     *
     * @return DeleteStatement
     */
    public function delete()
    {
        return new DeleteStatement($this->currentConnection);
    }

    /**
     * Update rows
     *
     * @param array $columns
     * @return UpdateStatement
     */
    public function update(array $columns = [])
    {
        return new UpdateStatement($this->currentConnection, $columns);
    }

    /**
     * Execute Raw queries
     *
     * @param $statement
     * @param array $values
     * @return RawStatement
     */
    public function raw($statement, array $values = [])
    {
        return new RawStatement($this->currentConnection, $statement, $values);
    }

    /**
     * Run queries in transaction mode
     *
     * @param Closure $callback
     * @return TransactionStatement
     */
    public function transaction(Closure $callback)
    {
        return new TransactionStatement($this, $this->currentConnection, $callback);
    }
}