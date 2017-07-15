<?php
/**
 * Created by PhpStorm.
 * User: robert.asproniu
 * Date: 7/15/2017
 * Time: 11:09 AM
 */

namespace SimpleDataBaseOrm\Connectors\Adapters;

use Closure;
use PDO as PdoLib;
use PDOStatement;
use Exception;
use Throwable;

/**
 * Class Pdo
 *
 * @property PDOStatement $statement
 * @property PdoLib $pdo
 * @property int $transactions
 */

class Pdo implements ConnectionInterface
{
    private $pdo;

    private $transactions = 0;

    private $statement = null;

    /**
     * Pdo constructor.
     * @param PdoLib $pdo
     */
    function __construct(PdoLib $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Execute particular Query
     *
     * @param $query
     * @param array $values
     * @return mixed
     */
    public function query($query, array $values = [])
    {
        $this->statement = $this->pdo->prepare($query);

        $this->statement->execute($values);

    }

    /**
     * Open or execute a transaction
     *
     * @param Closure|null $callback
     * @return mixed|void
     * @throws Exception
     * @throws Throwable
     */
    public function transaction(Closure $callback = null)
    {
        if (! $this->transactions )
        {
            $this->pdo->beginTransaction();
        }

        if ($callback && is_callable($callback))
        {
            try
            {
                call_user_func($callback);

                $this->commit();
            }
            catch (Exception $exception)
            {
                $this->rollback();

                throw $exception;
            }
            catch (Throwable $exception)
            {
                $this->rollback();

                throw $exception;
            }
        }
    }

    /**
     * Commit transaction
     *
     *
     */
    public function commit()
    {
        if ($this->transactions == 1)
        {
            $this->pdo->commit();
        }

        $this->transactions--;
    }

    /**
     * Rollback transaction
     *
     */
    public function rollback()
    {
        if ($this->transactions == 1)
        {
            $this->transactions = 0;

            $this->pdo->rollBack();
        }
        else
        {
            $this->transactions--;
        }
    }

    public function id()
    {
        return $this->pdo->lastInsertId();
    }

    public function rows()
    {
        return $this->statement->rowCount();
    }

    /**
     * Fetch result
     *
     * @return array
     */
    public function fetch()
    {
        $results = [];

        if ($this->statement)
        {
            $results = $this->statement->fetchAll();
        }

        return $results;
    }
}