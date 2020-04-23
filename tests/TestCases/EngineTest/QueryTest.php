<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;

/**
 * Class QueryTest
 *
 * @package Tests\TestCases\EngineTest
 *
 * The known data set looks like this:
 *
 * -------------------------------------------------
 *   ID  |  Item            |  Categories  | Topics
 * -------------------------------------------------
 *   1   |  DataTypeOne1    |     1,2      |    1
 *   2   |  DataTypeOne2    |     3,4,5    |    2
 *   3   |  DataTypeTwo1    |     2,3,5    |    2
 *   4   |  DataTypeTwo2    |      3       |   2,3
 *   5   |  DataTypeThree1  |      4       |    -
 * -------------------------------------------------
 *
 * This means that the following relations exist:
 *
 * (1) is related to (3; score 1)
 * (2) is related to (3; score 3), (4; score 2), and (5; score 1)
 * (3) is related to (1; score 1), (2; score 3), and (4; score 2)
 * (4) is related to (2; score 2) and (3; score 2)
 * (5) is related to (2; score 1)
 *
 * So, for each item the result set should be like this (in order)
 *
 * (1) = 1 hit, items: 3
 * (2) = 3 hits, items: 3,4,5
 * (3) = 3 hits, items: 2,4,1
 * (4) = 2 hits, items: 2,3
 * (5) = 1 hit, items: 2
 *
 */
class QueryTest extends TestCase
{
    /** @var Engine */
    static $oEngine;

    // --------------------------------------------------------------------------

    public static function setUpBeforeClass(): void
    {
        static::$oEngine = new Engine(new Store\Ephemeral());

        $dt1analyser = new Mocks\Analysers\DataTypeOne();
        $dt1object1  = new Mocks\Objects\DataTypeOne1();
        $dt1object2  = new Mocks\Objects\DataTypeOne2();

        $dt2analyser = new Mocks\Analysers\DataTypeTwo();
        $dt2object1  = new Mocks\Objects\DataTypeTwo1();
        $dt2object2  = new Mocks\Objects\DataTypeTwo2();

        $dt3analyser = new Mocks\Analysers\DataTypeThree();
        $dt3object1  = new Mocks\Objects\DataTypeThree1();

        static::$oEngine
            ->index($dt1object1, $dt1analyser)
            ->index($dt1object2, $dt1analyser)
            ->index($dt2object1, $dt2analyser)
            ->index($dt2object2, $dt2analyser)
            ->index($dt3object1, $dt3analyser);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_first_arg_is_required()
    {
        $this->expectException(\ArgumentCountError::class);
        static::$oEngine->query();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_second_arg_is_required()
    {
        $this->expectException(\ArgumentCountError::class);
        static::$oEngine->query(new Mocks\Objects\DataTypeOne1());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_first_arg_must_be_instance_of_object()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine->query(null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_second_arg_must_be_instance_of_analyser()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine->query(new Mocks\Objects\DataTypeOne1(), null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_third_arg_must_be_array()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeOne1(),
                new Mocks\Analysers\DataTypeOne(),
                null
            );
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_third_arg_must_be_array_of_analysers()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeOne1(),
                new Mocks\Analysers\DataTypeOne(),
                [null]
            );
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_fourth_arg_must_be_an_int()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeOne1(),
                new Mocks\Analysers\DataTypeOne(),
                [],
                'string'
            );
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_returns_related_items()
    {
        // Testing (1); expecting 1 hit
        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeOne1(),
                new Mocks\Analysers\DataTypeOne()
            );

        $this->assertCount(1, $hits);

        // Testing (2); expecting 3 hits
        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeOne2(),
                new Mocks\Analysers\DataTypeOne()
            );

        $this->assertCount(3, $hits);

        // Testing (3); expecting 3 hits
        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeTwo1(),
                new Mocks\Analysers\DataTypeTwo()
            );

        $this->assertCount(3, $hits);

        // Testing (4); expecting 2 hits
        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeTwo2(),
                new Mocks\Analysers\DataTypeTwo()
            );

        $this->assertCount(2, $hits);

        // Testing (4); expecting 1 hit1
        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeThree1(),
                new Mocks\Analysers\DataTypeThree()
            );

        $this->assertCount(1, $hits);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_returns_related_items_of_type()
    {
        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeTwo1(),
                new Mocks\Analysers\DataTypeTwo(),
                [
                    new Mocks\Analysers\DataTypeTwo(),
                ]
            );
        $hit  = reset($hits);

        $this->assertCount(1, $hits);
        $this->assertEquals(Mocks\Analysers\DataTypeTwo::class, $hit->getType());
        $this->assertEquals(2, $hit->getId());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_returns_limited_number_of_related_items()
    {
        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeTwo1(),
                new Mocks\Analysers\DataTypeTwo()
            );

        $this->assertCount(3, $hits);

        $hits = static::$oEngine
            ->query(
                new Mocks\Objects\DataTypeTwo1(),
                new Mocks\Analysers\DataTypeTwo(),
                [],
                2
            );

        $this->assertCount(2, $hits);
    }
}
