<?php

namespace SimpleDataBaseOrm\Query\Clauses;


class OrderClause extends Clause
{

    public function orderBy($column, $direction = "ASC")
    {
        array_push($this->clauses, sprintf(" `%s` %s", $column, $direction));
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