<?php

use PHPUnit\Framework\TestCase;
use SimpleDataBaseOrm\DatabaseConfiguration;

class DatabaseConfigurationTest extends TestCase
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
