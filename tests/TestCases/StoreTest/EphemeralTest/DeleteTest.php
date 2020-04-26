<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
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
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::delete
     * @throws NotConnectedException
     */
    public function test_can_delete_data(): void
    {
        $store = static::getStore();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->assertGreaterThan(0, count($relations));

        $store->write($entity, $id, $relations);

        $this->assertCount(count($relations), $store->dump());

        $store->delete($entity, $id);

        $this->assertCount(0, $store->dump());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::delete
     * @throws NotConnectedException
     */
    public function test_deletes_data_for_item(): void
    {
        $store = static::getStore();

        [$entity, $object1, $id1, $relations1] = $this->getDataTypeOne1();
        [$entity, $object2, $id2, $relations2] = $this->getDataTypeOne2();

        $this->assertGreaterThan(0, count($relations1));
        $this->assertGreaterThan(0, count($relations2));

        $store
            ->write($entity, $id1, $relations1)
            ->write($entity, $id2, $relations2);

        $this->assertCount(count($relations1) + count($relations2), $store->dump());

        $store
            ->delete($entity, $id1);

        $this->assertCount(count($relations2), $store->dump());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::delete
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::delete
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
