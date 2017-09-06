<?php

namespace SimpleDataBaseOrm\Query\Clauses;


use SimpleDataBaseOrm\Query\Exceptions\ClauseInvalidArgumentException;

class OrderClause extends Clause
{
	private $directions = ['ASC', 'DESC'];

	public function orderBy($column, $direction = "ASC")
    {
        if (!in_array($direction, $this->directions))
        {
        	throw new ClauseInvalidArgumentException("Wrong order direction");
        }

        if ($column)
        {
	        array_push($this->clauses, sprintf("`%s` %s", $column, $direction));
        }
    }

    /**
     * Convert clause to string
     *
     * @return string
     */
    public function __toString()
    {
        if (empty($this->clauses))
        {
            return '';
        }

        return sprintf(" ORDER BY %s ", implode(', ', $this->clauses));
    }
}