<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use HelloPablo\RelatedContentEngine\Exception\MissingExtension;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use PDO;
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
     * @throws NotConnectedException
     * @throws MissingExtension
     */
    public function test_can_disconnect_from_mysql(): void
    {
        $store = static::getStore();

        static::assertTrue($store->isConnected());
        static::assertInstanceOf(PDO::class, $store->getConnection());

        $store->disconnect();

        static::assertFalse($store->isConnected());
        static::assertNull($store->getConnection());
    }
}
