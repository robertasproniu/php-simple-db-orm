<?php
/**
 * Created by PhpStorm.
 * User: robert.aproniu
 * Date: 07/09/2017
 * Time: 00:36
 */
namespace SimpleDatabaseOrm\Tests\Query\Clauses;

use PHPUnit\Framework\TestCase;
use SimpleDataBaseOrm\Query\Clauses\LimitClause;

class LimitClauseTest extends TestCase
{

	/**
	 * Data for testLimitThrowsException
	 *
	 * @return array
	 */
	public function returnLimitExceptionData()
	{
		return [
			['abc', null],
			['abc', 'def'],
			[10,'bb'],
			[0,'bb']
		];
	}

	/**
	 * Data for testLimit
	 *
	 * @return array
	 */
	public function returnLimitData()
	{
		return [
			[10, null, " LIMIT 10 "],
			[10, 0, " LIMIT 10 OFFSET 0 "],
			['10','10', " LIMIT 10 OFFSET 10 "]
		];
	}


	/**
	 * @dataProvider returnLimitExceptionData
	 *
	 * @expectedException \SimpleDataBaseOrm\Query\Exceptions\ClauseInvalidArgumentException
	 */
	public function testLimitThrowsException($limit, $offset)
	{
		(new LimitClause())->limit($limit, $offset);
	}

	/**
	 * @dataProvider returnLimitData
	 */
	public function testLimit($limit, $offset, $expected)
	{
		$limitClause = new LimitClause();

		$limitClause->limit($limit, $offset);

		$this->assertEquals($expected, $limitClause);
	}
}
