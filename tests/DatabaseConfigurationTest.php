<?php

namespace SimpleDatabaseOrm\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use SimpleDataBaseOrm\DatabaseConfiguration;

class DatabaseConfigurationTest extends TestCase
{
	/**
	 * @var ReflectionClass
	 */
	private $dbConfiguration = null;

	public function setUp()
	{
		$this->dbConfiguration = new ReflectionClass(DatabaseConfiguration::class);
	}

	/**
	 * @return ReflectionMethod
	 */

	private function setAccessibleMethod($name)
	{
		$method = $this->dbConfiguration->getMethod( $name );
		$method->setAccessible( true );

		return $method;
	}

	public function returnConfigurations(  ) {
		return [
			[require __DIR__.'/dummy/configuration.php'],
			[[
				'connections' => []
			]],
			[[
				'default' => 'mysql',
				'connections' => [
					'default' => []
				]
			]],
			[[
				'default' => 'default',
				'connections' => [
					'default' => [
						'hostname' => 'localhost'
					]
				]
			]]
		];
	}

	/**
	 * Test if reading configuration throws an exception
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage No Database configurations were provided
	 */
    public function testReadConfigurationTrowsException()
    {
	    $method = $this->setAccessibleMethod('readConfig');

	    $method->invoke($this->dbConfiguration->newInstanceWithoutConstructor(), 11);

    }

	/**
	 * Check if reading configuration from file or array will return an array
	 */

    public function testReadConfigurationFileOrArray()
    {
	    $method = $this->setAccessibleMethod('readConfig');

	    $this->assertEquals([], $method->invoke($this->dbConfiguration->newInstanceWithoutConstructor(), __DIR__.'/dummy/configuration.php'));

	    $this->assertEquals([], $method->invoke($this->dbConfiguration->newInstanceWithoutConstructor(), []));
    }

	/**
	 * Check if validate configurations throws exceptions
	 *
	 * @dataProvider returnConfigurations
	 * @expectedException InvalidArgumentException
	 */
	public function testValidateConfigurationThrowsException($configuration)
	{
		$method = $this->setAccessibleMethod('validateConfig');

		$method->invoke($this->dbConfiguration->newInstance($configuration));

	}

	/**
	 * Check if Pass validation
	 *
	 */
	public function testValidateConfiguration()
	{
		$method = $this->setAccessibleMethod('validateConfig');

		$results = $method->invoke($this->dbConfiguration->newInstance([
			'default' => 'default',
			'connections' => [
				'default' => [
					'hostname'  => 'localhost',
					'driver'    => 'mysql',
					'database'  => 'database'
				]
			]
		]));

		$this->assertSame(null, $results);
	}


	/**
	 * Check if return proper value based by dotted key
	 */
	public function testGetByKey(  )
	{
		$instance = $this->dbConfiguration->newInstance([
			'default' => 'default',
			'connections' => [
				'default' => [
					'hostname'  => 'localhost',
					'driver'    => 'mysql',
					'database'  => 'database'
				]
			]
		]);

		$this->assertEquals(null, $instance->get('connections.mysql'));

		$this->assertEquals([
			'hostname'  => 'localhost',
			'driver'    => 'mysql',
			'database'  => 'database'
		], $instance->get('connections.default'));
	}

}
