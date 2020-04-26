<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class EmptyTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class EmptyTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::empty
     * @covers \HelloPablo\RelatedContent\Store\MySQL::empty
     * @throws NotConnectedException
     */
    public function test_can_empty_store(): void
    {
        $store = static::getStore(['seed' => true]);

        $data = $store->dump();
        static::assertNotEmpty($data);
        static::assertCount(1, $data);

        $store->empty();

        $data = $store->dump();
        static::assertEmpty($data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::empty
     * @covers \HelloPablo\RelatedContent\Store\MySQL::empty
     * @throws NotConnectedException
     */
    public function test_throws_exception_if_disconnected()
    {
        $store = static::getStore();
        $store->disconnect();

        $this->expectException(Exception::class);
        $store->empty();
    }
}
