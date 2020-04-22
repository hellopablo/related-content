<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContentEngine\Engine;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;

/**
 * Class ReadTest
 *
 * @package Tests\TestCases
 */
class ReadTest extends TestCase
{
    /** @var Engine */
    static $oEngine;

    // --------------------------------------------------------------------------

    public static function setUpBeforeClass(): void
    {
        static::$oEngine = new Engine(new Mocks\Store([]));
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::read
     */
    public function test_first_arg_is_required_field()
    {
        $this->expectException(\ArgumentCountError::class);
        static::$oEngine->index();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::read
     */
    public function test_second_arg_is_required_field()
    {
        $this->expectException(\ArgumentCountError::class);
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::read
     */
    public function test_first_arg_must_be_instance_of_object()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine->index(null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::read
     */
    public function test_second_arg_must_be_instance_of_analyser()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1(), null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::read
     */
    public function test_read_returns_all_relations_for_item()
    {
        $object1  = new Mocks\Objects\DataTypeOne1();
        $analyser = new Mocks\Analysers\DataTypeOne();

        $relations = static::$oEngine
            ->index($object1, $analyser)
            ->read($object1, $analyser);

        $this->assertNotEmpty($relations);
        $this->assertCount(3, $relations);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::read
     */
    public function test_read_returns_for_specific_item()
    {
        $object1  = new Mocks\Objects\DataTypeOne1();
        $object2  = new Mocks\Objects\DataTypeOne2();
        $analyser = new Mocks\Analysers\DataTypeOne();
        $store    = static::$oEngine->getStore();

        //  Clear data store
        $store->data = [];

        $relations = static::$oEngine
            ->index($object1, $analyser)
            ->index($object2, $analyser)
            ->read($object1, $analyser);

        $this->assertNotEmpty($relations);
        $this->assertCount(6, $store->data);
        $this->assertCount(3, $relations);
    }
}
