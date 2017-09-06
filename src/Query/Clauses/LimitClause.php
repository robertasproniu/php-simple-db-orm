<?php

namespace SimpleDataBaseOrm\Query\Clauses;


use SimpleDataBaseOrm\Query\Exceptions\ClauseInvalidArgumentException as ClauseInvalidArgumentException;

class LimitClause extends Clause
{
    public function limit($limit, $offset = null)
    {
    	if (!is_numeric($limit) || !$limit || (isset($offset) && !is_numeric($offset)))
        {
            throw new ClauseInvalidArgumentException("Invalid arguments. Limit or Offset value should be integer.");
        }

        array_push($this->clauses, sprintf(" LIMIT %s ", (string) $limit ));

        if (isset($offset))
        {
        	array_push($this->clauses, sprintf("OFFSET %s ",  (string) $offset));
        }
    }

    /**
     * Convert clause to string
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s", implode('', $this->clauses));
    }
}