<?php

namespace SimpleDataBaseOrm\Query\Clauses;


use SimpleDataBaseOrm\Query\Exceptions\ClauseInvalidArgumentException;

/**
 * Class WhereClause
 * @package SimpleDataBaseOrm\Query\Clauses
 *
 * @property array $clauses
 * @property array $operators
 * @property array chains
 *
 */
class WhereClause extends Clause
{

    /**
     * Keep all allowed operators
     *
     * @var array
     */
    private $operators = [
        '=',
        '>',
        '<',
        '>=',
        '<=',
        '<>'
    ];

    /**
     * Keep all allowed chains
     *
     * @var array
     */
    private $chains = ["AND", "OR"];

    /**
     * Parse operator to match with allowed ones
     *
     * @param null $operator
     * @return string
     */
    private function parseOperator($operator = null)
    {
        if (! $operator)
        {
            $operator = $this->operators[0];
        }

        if (! in_array( strtoupper($operator), array_keys($this->operators)) )
        {
            throw new ClauseInvalidArgumentException(sprintf("Invalid  operator provided. Allowed %s", implode(',', $this->operators)));
        }

        return strtoupper($operator);
    }

    /**
     * Parse chain to match with allowed ones
     *
     * @param null $chain
     * @return string
     */
    private function parseChain($chain = null)
    {
        if (!$chain)
        {
            $chain = $this->chains[0];
        }

        if (!in_array(strtoupper($chain), $this->chains))
        {
            throw new ClauseInvalidArgumentException(sprintf("Invalid  chain provided. Allowed %s", implode(',', $this->chains)));
        }

        return strtoupper($chain);
    }

    /**
     * Where clause
     *
     * @param $column
     * @param string $operator
     * @param string $chain
     */

    public function where($column, $operator = null, $chain = null)
    {
        $operator = $this->parseOperator($operator);

        $chain = $this->parseChain($chain);

        $value =  !empty($this->operators[$operator]) ? $this->operators[$operator] : '?';

        array_push($this->clauses, sprintf("%s `%s` %s %s ", $chain, $column, $operator, $value));
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

        return sprintf(" WHERE (%s) ", ltrim(implode('', $this->clauses), 'AND'));
    }
}