<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use HelloPablo\RelatedContent\Exception\NotConnectedException;
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
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::connect
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::disconnect
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::isConnected
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::getConnection
     * @throws NotConnectedException
     */
    public function test_can_disconnect(): void
    {
        $store = static::getStore();

        static::assertTrue($store->isConnected());
        static::assertIsArray($store->getConnection());

        $store->disconnect();

        static::assertFalse($store->isConnected());
        static::assertNull($store->getConnection());
    }
}
