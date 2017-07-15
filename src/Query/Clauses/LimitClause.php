<?php

namespace SimpleDataBaseOrm\Query\Clauses;


use SimpleDataBaseOrm\Query\Exceptions\ClauseInvalidArgumentException;

class LimitClause extends Clause
{
    public function limit($limit, $offset = null)
    {
        if (!settype($limit, "integer") || ($offset && !settype($limit, "integer")))
        {
            throw new ClauseInvalidArgumentException("Invalid arguments. Limit or Offset value should be integer.");
        }

        array_push($this->clauses, sprintf(" LIMIT %s ", $limit) );

        if ($offset)
        {
            array_push($this->clauses, sprintf(" OFFSET %s ", $offset));
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

        return sprintf("%s", implode(' ', $this->clauses));
    }
}