<?php
/**
 * Created by PhpStorm.
 * User: robert.asproniu
 * Date: 7/15/2017
 * Time: 8:03 PM
 */

namespace SimpleDataBaseOrm\Query\Statements\Traits;


trait AttachWhereClauseTrait
{
    /**
     * Add where clause
     *
     * @param $column
     * @param null|mixed $operatorValue
     * @param null|mixed $value
     * @param null|string $chain
     * @return $this
     */

    public function where($column, $operatorValue = null, $value = null, $chain = null)
    {
        if (func_num_args() == 2)
        {
            list($value, $operatorValue) = [$operatorValue, null];
        }

        $this->values[] = is_array($value) ? array_merge($this->values, $value) : $value;

        $this->whereClause->where($column, $operatorValue, $chain);

        return $this;
    }
}