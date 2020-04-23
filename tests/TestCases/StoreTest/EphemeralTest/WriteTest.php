<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Interfaces;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;

/**
 * Class WriteTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class WriteTest extends TestCase
{
    use Traits\Utilities;
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::write
     * @throws Exception
     */
    public function test_can_write_data()
    {
        $store = $this->getStore();

        [$analyser, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->assertGreaterThan(0, count($relations));

        $store->write($analyser, $id, $relations);

        $data = $store->dump();
        $this->assertCount(count($relations), $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::write
     * @throws Exception
     */
    public function test_method_returns_instance_of_store()
    {
        $store = $this->getStore();

        [$analyser, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->assertGreaterThan(0, count($relations));

        $this->assertInstanceOf(
            Interfaces\Store::class,
            $store->write($analyser, $id, $relations)
        );
    }
}
