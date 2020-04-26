<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use HelloPablo\RelatedContent\Exception\MissingExtension;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Store;
use PDO;
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
     * @covers \HelloPablo\RelatedContent\Store\MySQL::connect
     * @throws NotConnectedException
     * @throws MissingExtension
     */
    public function test_fails_to_connect_with_bad_credentials(): void
    {
        $this->expectException(NotConnectedException::class);

        $store = new Store\MySQL([]);
        $store->connect();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\MySQL::connect
     * @covers \HelloPablo\RelatedContent\Store\MySQL::isConnected
     * @covers \HelloPablo\RelatedContent\Store\MySQL::getConnection
     * @throws NotConnectedException
     * @throws MissingExtension
     */
    public function test_can_connect_to_mysql(): void
    {
        $store = static::getStore();

        static::assertTrue($store->isConnected());
        static::assertInstanceOf(PDO::class, $store->getConnection());
    }
}
