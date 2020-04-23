<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class ConnectTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class ConnectTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::connect
     */
    public function test_fails_to_connect_with_bad_credentials()
    {
        $this->expectException(\PDOException::class);

        $store = new Store\MySQL([]);
        $store->connect();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::getConnection
     * @throws Exception
     */
    public function test_can_connect_to_mysql()
    {
        $store = $this->getStore();

        $this->assertTrue($store->isConnected());
        $this->assertInstanceOf(\PDO::class, $store->getConnection());
    }
}
