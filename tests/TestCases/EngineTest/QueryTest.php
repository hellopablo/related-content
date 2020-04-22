<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContentEngine\Engine;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;

/**
 * Class QueryTest
 *
 * @package Tests\TestCases
 */
class QueryTest extends TestCase
{
    /** @var Engine */
    static $oEngine;

    // --------------------------------------------------------------------------

    public static function setUpBeforeClass(): void
    {
        static::$oEngine = new Engine(new Mocks\Store([]));

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
    public function test_first_arg_is_required_field()
    {
        $this->expectException(\ArgumentCountError::class);
        static::$oEngine->query();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_second_arg_is_required_field()
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
        //  @todo (Pablo - 2020-04-22) - Complete this
        $this->markTestIncomplete();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::query
     */
    public function test_returns_related_items_of_type()
    {
        //  @todo (Pablo - 2020-04-22) - Complete this
        $this->markTestIncomplete();
    }
}
