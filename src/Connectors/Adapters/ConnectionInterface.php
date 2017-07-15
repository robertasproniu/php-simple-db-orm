<?php
/**
 * Created by PhpStorm.
 * User: robert.asproniu
 * Date: 7/15/2017
 * Time: 11:19 AM
 */

namespace SimpleDataBaseOrm\Connectors\Adapters;

use Closure;

interface ConnectionInterface
{
    /**
     * Prepare and execute the query
     *
     * @param $query
     * @param array $properties
     * @param bool $fetch
     * @return mixed
     */
    public function query($query, array $properties = []);

    /**
     * Fetch result
     *
     * @return array
     */
    public function fetch();

    /**
     * return last inserted id
     *
     * @return mixed
     */

    public function id();

    /**
     * return affected rows
     *
     * @return mixed
     */
    public function rows();

    /**
     * @param Closure|null $callback
     * @return mixed
     */
    public function transaction(Closure $callback = null);

    public function commit();

    public function rollback();

}