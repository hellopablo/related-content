<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
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
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::connect
     * @throws Exception
     */
    public function test_fails_to_connect_when_will_connect_is_false()
    {
        $this->expectException(Exception::class);
        static::getStore(['will_connect' => false]);
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
        $store = static::getStore();

        $this->assertTrue($store->isConnected());
        $this->assertIsArray($store->getConnection());
    }
}
