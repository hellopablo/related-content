<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
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
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::read
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::read
     * @throws Exception
     */
    public function test_can_read_data(): void
    {
        $store = static::getStore();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->assertGreaterThan(0, count($relations));

        $store->write($entity, $id, $relations);

        $data = $store->read($entity, $id);

        $this->assertCount(count($relations), $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::read
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::read
     * @throws Exception
     */
    public function test_read_returns_data_for_requested_item_only(): void
    {
        $store = static::getStore();

        [$entity, $object1, $id1, $relations1] = $this->getDataTypeOne1();
        [$entity, $object2, $id2, $relations2] = $this->getDataTypeOne2();

        $this->assertGreaterThan(0, count($relations1));
        $this->assertGreaterThan(0, count($relations2));

        $store
            ->write($entity, $id1, $relations1)
            ->write($entity, $id2, $relations2);

        $data = $store->read($entity, $id1);

        $this->assertCount(count($relations1) + count($relations2), $store->dump());
        $this->assertCount(count($relations1), $data);
    }
}
