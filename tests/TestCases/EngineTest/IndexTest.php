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
 * Class IndexTest
 *
 * @package Tests\TestCases\EngineTest
 */
class IndexTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /** @var Interfaces\Store */
    protected static Interfaces\Store $oStore;

    /** @var Engine */
    protected static Engine $oEngine;

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
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_first_arg_is_required(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_second_arg_is_required(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_first_arg_must_be_instance_of_object(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_second_arg_must_be_instance_of_analyser(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1(), null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_object_is_indexed(): void
    {
        $object = new Mocks\Objects\DataTypeOne1();

        static::$oEngine->index(
            $object,
            new Mocks\Analysers\DataTypeOne()
        );

        $data = static::$oEngine->dump();
        static::assertNotEmpty($data);
        static::assertCount(3, $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_duplicate_indexing_does_not_Result_in_duplicate_indexes(): void
    {
        $object1 = new Mocks\Objects\DataTypeOne1();

        static::$oEngine->empty();

        static::$oEngine
            ->index(
                $object1,
                new Mocks\Analysers\DataTypeOne()
            )
            ->index(
                $object1,
                new Mocks\Analysers\DataTypeOne()
            );

        $data = static::$oEngine->dump();
        static::assertNotEmpty($data);
        static::assertCount(3, $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_index_returns_instance_of_engine(): void
    {
        static::assertInstanceOf(
            Engine::class,
            static::$oEngine->index(
                new Mocks\Objects\DataTypeOne1(),
                new Mocks\Analysers\DataTypeOne()
            )
        );
    }
}
