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
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::query
     * @throws Exception
     */
    public function test_can_query_data()
    {
        $store = $this->getStore();

        $dt1analyser = new Mocks\Analysers\DataTypeOne();
        $dt1object1  = new Mocks\Objects\DataTypeOne1();
        $dt1object2  = new Mocks\Objects\DataTypeOne2();

        $dt2analyser = new Mocks\Analysers\DataTypeTwo();
        $dt2object1  = new Mocks\Objects\DataTypeTwo1();
        $dt2object2  = new Mocks\Objects\DataTypeTwo2();

        $dt3analyser = new Mocks\Analysers\DataTypeThree();
        $dt3object1  = new Mocks\Objects\DataTypeThree1();

        $store
            ->write($dt1analyser, $dt1analyser->getId($dt1object1), $dt1analyser->analyse($dt1object1))
            ->write($dt1analyser, $dt1analyser->getId($dt1object2), $dt1analyser->analyse($dt1object2))
            ->write($dt2analyser, $dt2analyser->getId($dt2object1), $dt2analyser->analyse($dt2object1))
            ->write($dt2analyser, $dt2analyser->getId($dt2object2), $dt2analyser->analyse($dt2object2))
            ->write($dt3analyser, $dt3analyser->getId($dt3object1), $dt3analyser->analyse($dt3object1));

        // Testing (1); expecting 1 hit
        $hits = $store
            ->query(
                $dt1analyser->analyse($dt1object1),
                get_class($dt1analyser),
                $dt1analyser->getId($dt1object1)
            );

        $this->assertCount(1, $hits);

        // Testing (2); expecting 3 hits
        $hits = $store
            ->query(
                $dt1analyser->analyse($dt1object2),
                get_class($dt1analyser),
                $dt1analyser->getId($dt1object2)
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

        $dt1analyser = new Mocks\Analysers\DataTypeOne();
        $dt1object1  = new Mocks\Objects\DataTypeOne1();
        $dt1object2  = new Mocks\Objects\DataTypeOne2();

        $dt2analyser = new Mocks\Analysers\DataTypeTwo();
        $dt2object1  = new Mocks\Objects\DataTypeTwo1();
        $dt2object2  = new Mocks\Objects\DataTypeTwo2();

        $dt3analyser = new Mocks\Analysers\DataTypeThree();
        $dt3object1  = new Mocks\Objects\DataTypeThree1();

        $store
            ->write($dt1analyser, $dt1analyser->getId($dt1object1), $dt1analyser->analyse($dt1object1))
            ->write($dt1analyser, $dt1analyser->getId($dt1object2), $dt1analyser->analyse($dt1object2))
            ->write($dt2analyser, $dt2analyser->getId($dt2object1), $dt2analyser->analyse($dt2object1))
            ->write($dt2analyser, $dt2analyser->getId($dt2object2), $dt2analyser->analyse($dt2object2))
            ->write($dt3analyser, $dt3analyser->getId($dt3object1), $dt3analyser->analyse($dt3object1));


        $hits = $store
            ->query(
                $dt2analyser->analyse($dt2object1),
                get_class($dt2analyser),
                $dt2analyser->getId($dt2object1),
                [
                    get_class($dt2analyser),
                ]
            );

        $hit  = reset($hits);

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

        $dt1analyser = new Mocks\Analysers\DataTypeOne();
        $dt1object1  = new Mocks\Objects\DataTypeOne1();
        $dt1object2  = new Mocks\Objects\DataTypeOne2();

        $dt2analyser = new Mocks\Analysers\DataTypeTwo();
        $dt2object1  = new Mocks\Objects\DataTypeTwo1();
        $dt2object2  = new Mocks\Objects\DataTypeTwo2();

        $dt3analyser = new Mocks\Analysers\DataTypeThree();
        $dt3object1  = new Mocks\Objects\DataTypeThree1();

        $store
            ->write($dt1analyser, $dt1analyser->getId($dt1object1), $dt1analyser->analyse($dt1object1))
            ->write($dt1analyser, $dt1analyser->getId($dt1object2), $dt1analyser->analyse($dt1object2))
            ->write($dt2analyser, $dt2analyser->getId($dt2object1), $dt2analyser->analyse($dt2object1))
            ->write($dt2analyser, $dt2analyser->getId($dt2object2), $dt2analyser->analyse($dt2object2))
            ->write($dt3analyser, $dt3analyser->getId($dt3object1), $dt3analyser->analyse($dt3object1));

        $hits = $store
            ->query(
                $dt2analyser->analyse($dt2object1),
                get_class($dt2analyser),
                $dt2analyser->getId($dt2object1)
            );

        $this->assertCount(3, $hits);

        $hits = $store
            ->query(
                $dt2analyser->analyse($dt2object1),
                get_class($dt2analyser),
                $dt2analyser->getId($dt2object1),
                [],
                2
            );

        $this->assertCount(2, $hits);
    }
}
