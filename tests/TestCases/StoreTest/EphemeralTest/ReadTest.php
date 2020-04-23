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
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::read
     * @throws Exception
     */
    public function test_can_read_data()
    {
        $store = $this->getStore();

        $analyser  = new Mocks\Analysers\DataTypeOne();
        $object    = new Mocks\Objects\DataTypeOne1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        $this->assertGreaterThan(0, count($relations));

        $store->write($analyser, $id, $relations);

        $data = $store->read($analyser, $id);

        $this->assertCount(count($relations), $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::read
     * @throws Exception
     */
    public function test_read_returns_data_for_requested_item_only()
    {
        $store = $this->getStore();

        $analyser   = new Mocks\Analysers\DataTypeOne();
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

        $data = $store->read($analyser, $id1);

        $this->assertCount(count($relations1) + count($relations2), $store->dump());
        $this->assertCount(count($relations1), $data);
    }
}
