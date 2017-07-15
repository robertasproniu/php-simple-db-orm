<?php
namespace SimpleDataBaseOrmTest;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DatabaseConfiguration extends TestCase
{
    /**
     * Test invalid configuration format
     *
     * @expectedException InvalidArgumentException
     */
    public function testConfigurationExceptions()
    {
        $this->expectException(InvalidArgumentException::class);

        new DatabaseConfiguration([
            'hostname' => '',
            'driver'   => 'mysql'
        ]);
    }
}
