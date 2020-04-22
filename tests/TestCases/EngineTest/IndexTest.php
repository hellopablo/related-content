<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContentEngine\Engine;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;

/**
 * Class IndexTest
 *
 * @package Tests\TestCases
 */
class IndexTest extends TestCase
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
     * @covers \HelloPablo\RelatedContentEngine\Engine::index
     */
    public function test_first_arg_is_required_field()
    {
        $this->expectException(\ArgumentCountError::class);
        static::$oEngine->index();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::index
     */
    public function test_second_arg_is_required_field()
    {
        $this->expectException(\ArgumentCountError::class);
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::index
     */
    public function test_first_arg_must_be_instance_of_object()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine->index(null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::index
     */
    public function test_second_arg_must_be_instance_of_analyser()
    {
        $this->expectException(\TypeError::class);
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1(), null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::index
     */
    public function test_object_is_indexed()
    {
        $object = new Mocks\Objects\DataTypeOne1();
        $store  = static::$oEngine->getStore();

        static::$oEngine->index(
            $object,
            new Mocks\Analysers\DataTypeOne()
        );

        $this->assertNotEmpty($store->data);
        $this->assertCount(3, $store->data);
    }

    // --------------------------------------------------------------------------

    public function test_duplicate_indexing_does_not_Result_in_duplicate_indexes()
    {
        $object1 = new Mocks\Objects\DataTypeOne1();
        $store   = static::$oEngine->getStore();

        //  Clear data store
        $store->data = [];

        static::$oEngine
            ->index(
                $object1,
                new Mocks\Analysers\DataTypeOne()
            )
            ->index(
                $object1,
                new Mocks\Analysers\DataTypeOne()
            );

        $this->assertNotEmpty($store->data);
        $this->assertCount(3, $store->data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::index
     */
    public function test_index_returns_instance_of_engine()
    {
        $this->assertInstanceOf(
            Engine::class,
            static::$oEngine->index(
                new Mocks\Objects\DataTypeOne1(),
                new Mocks\Analysers\DataTypeOne()
            )
        );
    }
}
