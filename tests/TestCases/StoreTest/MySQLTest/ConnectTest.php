<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use PHPUnit\Framework\TestCase;
use Tests\TestCases\StoreTest\MySQLTest;

/**
 * Class ConnectTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class ConnectTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::connect
     */
    public function test_fails_to_connect_with_bad_credentials()
    {
        $this->expectException(\PDOException::class);
        $store = MySQLTest::getStore(false);
        $store->connect();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::getConnection
     */
    public function test_can_connect_to_mysql()
    {
        $store = MySQLTest::getStore();
        $store->connect();

        $this->assertTrue($store->isConnected());
        $this->assertInstanceOf(\PDO::class, $store->getConnection());
    }
}
