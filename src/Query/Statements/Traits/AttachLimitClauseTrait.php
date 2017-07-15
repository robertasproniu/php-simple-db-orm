<?php
/**
 * Created by PhpStorm.
 * User: robert.asproniu
 * Date: 7/15/2017
 * Time: 8:07 PM
 */

namespace SimpleDataBaseOrm\Query\Statements\Traits;


trait AttachLimitClauseTrait
{
    /**
     * Add limit and offset
     *
     * @param null $number
     * @param null $offset
     * @return $this
     */
    public function limit($number = null, $offset = null)
    {
        if ($number)
        {
            $this->limitClause->limit($number, $offset);
        }

        return $this;
    }
}
