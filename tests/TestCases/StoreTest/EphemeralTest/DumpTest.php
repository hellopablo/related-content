<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class DumpTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class DumpTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::delete
     * @throws NotConnectedException
     */
    public function test_can_dump_data(): void
    {
        $store = static::getStore();
        $this->assertCount(0, $store->dump());

        $store = static::getStore(['seed' => true]);
        $this->assertCount(1, $store->dump());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::dump
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::dump
     * @throws NotConnectedException
     */
    public function test_throws_exception_if_disconnected()
    {
        $store = static::getStore();
        $store->disconnect();

        $this->expectException(Exception::class);
        $store->dump();
    }
}
