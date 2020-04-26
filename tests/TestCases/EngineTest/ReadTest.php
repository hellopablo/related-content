<?php

namespace Tests\TestCases\EngineTest;

use ArgumentCountError;
use HelloPablo\RelatedContent\Engine;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Interfaces;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;
use TypeError;

/**
 * Class ReadTest
 *
 * @package Tests\TestCases\EngineTest
 */
class ReadTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /** @var Interfaces\Store */
    protected static $oStore;

    /** @var Engine */
    protected static $oEngine;

    // --------------------------------------------------------------------------

    /**
     * @throws NotConnectedException
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$oStore  = static::getStore();
        static::$oEngine = new Engine(static::$oStore);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::read
     */
    public function test_first_arg_is_required(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::read
     */
    public function test_second_arg_is_required(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::read
     */
    public function test_first_arg_must_be_instance_of_object(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::read
     */
    public function test_second_arg_must_be_instance_of_analyser(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1(), null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::read
     */
    public function test_read_returns_all_relations_for_item(): void
    {
        $object1  = new Mocks\Objects\DataTypeOne1();
        $analyser = new Mocks\Analysers\DataTypeOne();

        $relations = static::$oEngine
            ->index($object1, $analyser)
            ->read($object1, $analyser);

        static::assertNotEmpty($relations);
        static::assertCount(3, $relations);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::read
     */
    public function test_read_returns_for_specific_item(): void
    {
        $object1  = new Mocks\Objects\DataTypeOne1();
        $object2  = new Mocks\Objects\DataTypeOne2();
        $analyser = new Mocks\Analysers\DataTypeOne();

        //  Clear data store
        static::$oEngine->empty();

        $relations = static::$oEngine
            ->index($object1, $analyser)
            ->index($object2, $analyser)
            ->read($object1, $analyser);

        $data = static::$oEngine->dump();
        static::assertNotEmpty($relations);
        static::assertCount(6, $data);
        static::assertCount(3, $relations);
    }
}
