<?php
/**
 * Created by PhpStorm.
 * User: robert.aproniu
 * Date: 07/09/2017
 * Time: 02:06
 */

namespace SimpleDatabaseOrm\Tests\Query\Clauses;

use PHPUnit\Framework\TestCase;
use SimpleDataBaseOrm\Query\Clauses\OrderClause;

class OrderClauseTest extends TestCase
{
	/**
	 * Data for testLimitThrowsException
	 *
	 * @return array
	 */
	public function returnOrderExceptionData()
	{
		return [
			['column', 'wrong']
		];
	}

	/**
	 * Data for testLimit
	 *
	 * @return array
	 */
	public function returnOrderData()
	{
		return [
			['column', 'ASC', " ORDER BY `column` ASC "],
			['column', 'DESC', " ORDER BY `column` DESC "],
			['', 'ASC', '']
		];
	}


	/**
	 * @dataProvider returnOrderExceptionData
	 *
	 * @expectedException \SimpleDataBaseOrm\Query\Exceptions\ClauseInvalidArgumentException
	 */
	public function testOrderThrowsException($column, $direction)
	{
		(new OrderClause())->orderBy($column, $direction);
	}

	/**
	 * @dataProvider returnOrderData
	 */
	public function testOrder($column, $direction, $expected)
	{
		$orderClause = new OrderClause();

		$orderClause->orderBy($column, $direction);

		$this->assertEquals($expected, $orderClause);
	}
}
