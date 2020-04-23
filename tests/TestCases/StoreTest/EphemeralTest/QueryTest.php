<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;

/**
 * Class QueryTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class QueryTest extends TestCase
{
    use Traits\Utilities;
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::query
     * @throws Exception
     */
    public function test_can_query_data()
    {
        $store = $this->getStore();

        [$dt1analyser, $dt1object1, $dt1id1, $dt1relations1] = $this->getDataTypeOne1();
        [$dt1analyser, $dt1object2, $dt1id2, $dt1relations2] = $this->getDataTypeOne2();
        [$dt2analyser, $dt2object1, $dt2id1, $dt2relations1] = $this->getDataTypeTwo1();
        [$dt2analyser, $dt2object2, $dt2id2, $dt2relations2] = $this->getDataTypeTwo2();
        [$dt3analyser, $dt3object1, $dt3id1, $dt3relations1] = $this->getDataTypeThree1();

        $store
            ->write($dt1analyser, $dt1id1, $dt1relations1)
            ->write($dt1analyser, $dt1id2, $dt1relations2)
            ->write($dt2analyser, $dt2id1, $dt2relations1)
            ->write($dt2analyser, $dt2id2, $dt2relations2)
            ->write($dt3analyser, $dt3id1, $dt3relations1);

        // Testing (1); expecting 1 hit
        $hits = $store
            ->query(
                $dt1relations1,
                get_class($dt1analyser),
                $dt1id1
            );

        $this->assertCount(1, $hits);

        // Testing (2); expecting 3 hits
        $hits = $store
            ->query(
                $dt1analyser->analyse($dt1object2),
                get_class($dt1analyser),
                $dt1id2
            );

        $this->assertCount(3, $hits);

        // Testing (3); expecting 3 hits
        $hits = $store
            ->query(
                $dt2analyser->analyse($dt2object1),
                get_class($dt2analyser),
                $dt2analyser->getId($dt2object1)
            );

        $this->assertCount(3, $hits);

        // Testing (4); expecting 2 hits
        $hits = $store
            ->query(
                $dt2analyser->analyse($dt2object2),
                get_class($dt2analyser),
                $dt2analyser->getId($dt2object2)
            );

        $this->assertCount(2, $hits);

        // Testing (4); expecting 1 hit1
        $hits = $store
            ->query(
                $dt3analyser->analyse($dt3object1),
                get_class($dt3analyser),
                $dt3analyser->getId($dt3object1)
            );

        $this->assertCount(1, $hits);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::query
     * @throws Exception
     */
    public function test_returns_related_items_of_type()
    {
        $store = $this->getStore();

        [$dt1analyser, $dt1object1, $dt1id1, $dt1relations1] = $this->getDataTypeOne1();
        [$dt1analyser, $dt1object2, $dt1id2, $dt1relations2] = $this->getDataTypeOne2();
        [$dt2analyser, $dt2object1, $dt2id1, $dt2relations1] = $this->getDataTypeTwo1();
        [$dt2analyser, $dt2object2, $dt2id2, $dt2relations2] = $this->getDataTypeTwo2();
        [$dt3analyser, $dt3object1, $dt3id1, $dt3relations1] = $this->getDataTypeThree1();

        $store
            ->write($dt1analyser, $dt1id1, $dt1relations1)
            ->write($dt1analyser, $dt1id2, $dt1relations2)
            ->write($dt2analyser, $dt2id1, $dt2relations1)
            ->write($dt2analyser, $dt2id2, $dt2relations2)
            ->write($dt3analyser, $dt3id1, $dt3relations1);

        $hits = $store
            ->query(
                $dt2relations1,
                get_class($dt2analyser),
                $dt2id1,
                [
                    get_class($dt2analyser),
                ]
            );

        $hit = reset($hits);

        $this->assertCount(1, $hits);
        $this->assertEquals(Mocks\Analysers\DataTypeTwo::class, $hit->getType());
        $this->assertEquals(2, $hit->getId());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::query
     * @throws Exception
     */
    public function test_returns_limited_number_of_related_items()
    {
        $store = $this->getStore();

        [$dt1analyser, $dt1object1, $dt1id1, $dt1relations1] = $this->getDataTypeOne1();
        [$dt1analyser, $dt1object2, $dt1id2, $dt1relations2] = $this->getDataTypeOne2();
        [$dt2analyser, $dt2object1, $dt2id1, $dt2relations1] = $this->getDataTypeTwo1();
        [$dt2analyser, $dt2object2, $dt2id2, $dt2relations2] = $this->getDataTypeTwo2();
        [$dt3analyser, $dt3object1, $dt3id1, $dt3relations1] = $this->getDataTypeThree1();

        $store
            ->write($dt1analyser, $dt1id1, $dt1relations1)
            ->write($dt1analyser, $dt1id2, $dt1relations2)
            ->write($dt2analyser, $dt2id1, $dt2relations1)
            ->write($dt2analyser, $dt2id2, $dt2relations2)
            ->write($dt3analyser, $dt3id1, $dt3relations1);

        $hits = $store
            ->query(
                $dt2relations1,
                get_class($dt2analyser),
                $dt2id1
            );

        $this->assertCount(3, $hits);

        $hits = $store
            ->query(
                $dt2relations1,
                get_class($dt2analyser),
                $dt2id1,
                [],
                2
            );

        $this->assertCount(2, $hits);
    }
}
