<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use PHPUnit\Framework\TestCase;
use Tests\TestCases\StoreTest\MySQLTest;

/**
 * Class DisconnectTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class DisconnectTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::disconnect
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::getConnection
     */
    public function test_can_disconnect_from_mysql()
    {
        $store = MySQLTest::getStore();
        $store->connect();

        $this->assertTrue($store->isConnected());
        $this->assertInstanceOf(\PDO::class, $store->getConnection());

        $store->disconnect();

        $this->assertFalse($store->isConnected());
        $this->assertNull($store->getConnection());
    }
}
