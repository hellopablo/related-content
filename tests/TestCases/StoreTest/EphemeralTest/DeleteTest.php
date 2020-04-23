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
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::delete
     * @throws Exception
     */
    public function test_can_delete_data()
    {
        $store = $this->getStore();

        $analyser = new Mocks\Analysers\DataTypeOne();

        $object    = new Mocks\Objects\DataTypeOne1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

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

        $analyser = new Mocks\Analysers\DataTypeOne();

        $object1    = new Mocks\Objects\DataTypeOne1();
        $id1        = $analyser->getId($object1);
        $relations1 = $analyser->analyse($object1);

        $object2    = new Mocks\Objects\DataTypeOne2();
        $id2        = $analyser->getId($object2);
        $relations2 = $analyser->analyse($object2);

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
