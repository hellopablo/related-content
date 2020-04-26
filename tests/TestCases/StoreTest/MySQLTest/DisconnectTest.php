<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use HelloPablo\RelatedContent\Exception\MissingExtension;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
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
     * @covers \HelloPablo\RelatedContent\Store\MySQL::connect
     * @covers \HelloPablo\RelatedContent\Store\MySQL::disconnect
     * @covers \HelloPablo\RelatedContent\Store\MySQL::isConnected
     * @covers \HelloPablo\RelatedContent\Store\MySQL::getConnection
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
