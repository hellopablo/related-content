<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use PHPUnit\Framework\TestCase;
use HelloPablo\RelatedContentEngine\Store;

/**
 * Class DisconnectTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class DisconnectTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::disconnect
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::getConnection
     * @throws Exception
     */
    public function test_can_disconnect()
    {
        $store = new Store\Ephemeral();
        $store->connect();

        $this->assertTrue($store->isConnected());
        $this->assertIsArray($store->getConnection());

        $store->disconnect();

        $this->assertFalse($store->isConnected());
        $this->assertNull($store->getConnection());
    }
}
