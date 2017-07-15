<?php

namespace SimpleDataBaseOrm\Query\Clauses;

abstract class Clause
{
    protected $clauses = [];

    /**
     * Convert clause to string
     *
     * @return string
     */
    abstract public function __toString();
}