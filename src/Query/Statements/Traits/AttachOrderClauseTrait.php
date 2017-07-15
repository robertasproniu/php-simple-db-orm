<?php
/**
 * Created by PhpStorm.
 * User: robert.asproniu
 * Date: 7/15/2017
 * Time: 8:07 PM
 */

namespace SimpleDataBaseOrm\Query\Statements\Traits;

trait AttachOrderClauseTrait
{
    /**
     * Set order or results
     *
     * @param $column
     * @param null $direction
     * @return $this
     */

    public function order($column, $direction = null)
    {
        $this->orderClause->orderBy($column, $direction);

        return $this;
    }
}