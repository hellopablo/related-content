<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class DisconnectTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class DisconnectTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::disconnect
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::getConnection
     * @throws NotConnectedException
     */
    public function test_can_disconnect(): void
    {
        $store = static::getStore();

        $this->assertTrue($store->isConnected());
        $this->assertIsArray($store->getConnection());

        $store->disconnect();

        $this->assertFalse($store->isConnected());
        $this->assertNull($store->getConnection());
    }
}
