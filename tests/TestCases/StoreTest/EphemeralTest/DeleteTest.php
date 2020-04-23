<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
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
     * @throws Exception
     */
    public function test_can_delete_data()
    {
        $store = $this->getStore();

        [$analyser, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->assertGreaterThan(0, count($relations));

        $store->write($analyser, $id, $relations);

        $this->assertCount(count($relations), $store->dump());

        $store->delete($analyser, $id);

        $this->assertCount(0, $store->dump());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::delete
     * @throws Exception
     */
    public function test_deletes_data_for_item()
    {
        $store = $this->getStore();

        [$analyser, $object1, $id1, $relations1] = $this->getDataTypeOne1();
        [$analyser, $object2, $id2, $relations2] = $this->getDataTypeOne2();

        $this->assertGreaterThan(0, count($relations1));
        $this->assertGreaterThan(0, count($relations2));

        $store
            ->write($analyser, $id1, $relations1)
            ->write($analyser, $id2, $relations2);

        $this->assertCount(count($relations1) + count($relations2), $store->dump());

        $store
            ->delete($analyser, $id1);

        $this->assertCount(count($relations2), $store->dump());
    }
}
