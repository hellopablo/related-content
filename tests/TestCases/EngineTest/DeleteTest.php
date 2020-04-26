<?php

namespace Tests\TestCases\EngineTest;

use ArgumentCountError;
use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use HelloPablo\RelatedContentEngine\Interfaces;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;
use TypeError;

/**
 * Class DeleteTest
 *
 * @package Tests\TestCases\EngineTest
 */
class DeleteTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /** @var Interfaces\Store */
    static $oStore;

    /** @var Engine */
    static $oEngine;

    // --------------------------------------------------------------------------

    /**
     * @throws NotConnectedException
     */
    public static function setUpBeforeClass(): void
    {
        static::$oStore  = static::getStore();
        static::$oEngine = new Engine(static::$oStore);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::delete
     */
    public function test_first_arg_is_required(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::delete
     */
    public function test_second_arg_is_required(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::delete
     */
    public function test_first_arg_must_be_instance_of_object(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::delete
     */
    public function test_second_arg_must_be_instance_of_analyser(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        static::$oEngine->index(new Mocks\Objects\DataTypeOne1(), null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::delete
     */
    public function test_object_is_deleted(): void
    {
        $object = new Mocks\Objects\DataTypeOne1();

        static::$oEngine
            ->index(
                $object,
                new Mocks\Analysers\DataTypeOne()
            );

        $data = static::$oEngine->dump();

        $this->assertNotEmpty($data);
        $this->assertCount(3, $data);

        static::$oEngine->delete(
            $object,
            new Mocks\Analysers\DataTypeOne()
        );

        $data = static::$oEngine->dump();
        $this->assertEmpty($data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::delete
     */
    public function test_just_this_object_is_deleted(): void
    {
        $object1 = new Mocks\Objects\DataTypeOne1();
        $object2 = new Mocks\Objects\DataTypeOne2();
        $store   = static::$oEngine->getStore();

        static::$oEngine
            ->index(
                $object1,
                new Mocks\Analysers\DataTypeOne()
            )
            ->index(
                $object2,
                new Mocks\Analysers\DataTypeOne()
            );

        $data = static::$oEngine->dump();
        $this->assertNotEmpty($data);
        $this->assertCount(6, $data);

        static::$oEngine->delete(
            $object1,
            new Mocks\Analysers\DataTypeOne()
        );

        $data = static::$oEngine->dump();
        $this->assertCount(3, $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::delete
     */
    public function test_delete_returns_instance_of_engine(): void
    {
        $this->assertInstanceOf(
            Engine::class,
            static::$oEngine->delete(
                new Mocks\Objects\DataTypeOne1(),
                new Mocks\Analysers\DataTypeOne()
            )
        );
    }
}
