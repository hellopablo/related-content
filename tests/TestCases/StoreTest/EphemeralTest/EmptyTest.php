<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
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
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::empty
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::empty
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
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::empty
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::empty
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
