<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class ConnectTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class ConnectTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::connect
     */
    public function test_fails_to_connect_when_will_connect_is_false()
    {
        $store = new Store\Ephemeral(['will_connect' => false]);

        $this->expectException(Exception::class);
        $store->connect();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::getConnection
     * @throws Exception
     */
    public function test_can_connect()
    {
        $store = new Store\Ephemeral();
        $store->connect();

        $this->assertTrue($store->isConnected());
        $this->assertIsArray($store->getConnection());
    }
}
