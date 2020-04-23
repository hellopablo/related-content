<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;

/**
 * Class WriteTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class WriteTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_can_write_data()
    {
        $store = new Store\Ephemeral();
        $store->connect();

        $analyser  = new Mocks\Analysers\DataTypeOne();
        $object    = new Mocks\Objects\DataTypeOne1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        $this->assertGreaterThan(0, count($relations));

        $store->write($analyser, $id, $relations);

        $data = $store->getConnection();
        $this->assertCount(count($relations), $data);
    }
}
