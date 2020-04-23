<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use PHPUnit\Framework\TestCase;
use Tests\TestCases\StoreTest\EphemeralTest;

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
    public function test_fails_to_connect_with_bad_credentials()
    {
        $this->markTestIncomplete();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::connect
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::isConnected
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::getConnection
     */
    public function test_can_connect_to_mysql()
    {
        $this->markTestIncomplete();
    }
}
