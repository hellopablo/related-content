<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
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
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContent\Store\MySQL::delete
     * @throws NotConnectedException
     */
    public function test_can_dump_data(): void
    {
        $store = static::getStore();
        static::assertCount(0, $store->dump());

        $store = static::getStore(['seed' => true]);
        static::assertCount(1, $store->dump());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::dump
     * @covers \HelloPablo\RelatedContent\Store\MySQL::dump
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
