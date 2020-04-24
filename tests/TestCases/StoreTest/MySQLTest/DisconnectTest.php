<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Exception;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class DisconnectTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class DisconnectTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::disconnect
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::getConnection
     * @throws Exception
     */
    public function test_can_disconnect_from_mysql(): void
    {
        $store = static::getStore();

        $this->assertTrue($store->isConnected());
        $this->assertInstanceOf(\PDO::class, $store->getConnection());

        $store->disconnect();

        $this->assertFalse($store->isConnected());
        $this->assertNull($store->getConnection());
    }
}
