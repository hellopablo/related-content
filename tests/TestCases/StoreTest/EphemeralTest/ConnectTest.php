<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use HelloPablo\RelatedContent\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class ConnectTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class ConnectTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::connect
     * @throws NotConnectedException
     */
    public function test_fails_to_connect_when_will_connect_is_false(): void
    {
        $this->expectException(NotConnectedException::class);
        static::getStore(['will_connect' => false]);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::connect
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::isConnected
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::getConnection
     * @throws NotConnectedException
     */
    public function test_can_connect(): void
    {
        $store = static::getStore();

        static::assertTrue($store->isConnected());
        static::assertIsArray($store->getConnection());
    }
}
