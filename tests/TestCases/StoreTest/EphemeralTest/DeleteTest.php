<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;

/**
 * Class DeleteTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class DeleteTest extends TestCase
{
    use Traits\Utilities;
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContent\Store\MySQL::delete
     * @throws NotConnectedException
     */
    public function test_can_delete_data(): void
    {
        $store = static::getStore();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        static::assertGreaterThan(0, count($relations));

        $store->write($entity, $id, $relations);

        static::assertCount(count($relations), $store->dump());

        $store->delete($entity, $id);

        static::assertCount(0, $store->dump());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContent\Store\MySQL::delete
     * @throws NotConnectedException
     */
    public function test_deletes_data_for_item(): void
    {
        $store = static::getStore();

        [$entity, $object1, $id1, $relations1] = $this->getDataTypeOne1();
        [$entity, $object2, $id2, $relations2] = $this->getDataTypeOne2();

        static::assertGreaterThan(0, count($relations1));
        static::assertGreaterThan(0, count($relations2));

        $store
            ->write($entity, $id1, $relations1)
            ->write($entity, $id2, $relations2);

        static::assertCount(count($relations1) + count($relations2), $store->dump());

        $store
            ->delete($entity, $id1);

        static::assertCount(count($relations2), $store->dump());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContent\Store\MySQL::delete
     * @throws NotConnectedException
     */
    public function test_throws_exception_if_disconnected()
    {
        $store = static::getStore();
        $store->disconnect();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->expectException(Exception::class);
        $store->delete($entity, $id);
    }
}
