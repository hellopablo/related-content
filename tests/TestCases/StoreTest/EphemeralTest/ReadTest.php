<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;

/**
 * Class ReadTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class ReadTest extends TestCase
{
    use Traits\Utilities;
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::read
     * @covers \HelloPablo\RelatedContent\Store\MySQL::read
     * @throws NotConnectedException
     */
    public function test_can_read_data(): void
    {
        $store = static::getStore();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        static::assertGreaterThan(0, count($relations));

        $store->write($entity, $id, $relations);

        $data = $store->read($entity, $id);

        static::assertCount(count($relations), $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::read
     * @covers \HelloPablo\RelatedContent\Store\MySQL::read
     * @throws NotConnectedException
     */
    public function test_read_returns_data_for_requested_item_only(): void
    {
        $store = static::getStore();

        [$entity, $object1, $id1, $relations1] = $this->getDataTypeOne1();
        [$entity, $object2, $id2, $relations2] = $this->getDataTypeOne2();

        static::assertGreaterThan(0, count($relations1));
        static::assertGreaterThan(0, count($relations2));

        $store
            ->write($entity, $id1, $relations1)
            ->write($entity, $id2, $relations2);

        $data = $store->read($entity, $id1);

        static::assertCount(count($relations1) + count($relations2), $store->dump());
        static::assertCount(count($relations1), $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::read
     * @covers \HelloPablo\RelatedContent\Store\MySQL::read
     * @throws NotConnectedException
     */
    public function test_throws_exception_if_disconnected()
    {
        $store = static::getStore();
        $store->disconnect();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->expectException(Exception::class);
        $store->read($entity, $id);
    }
}
