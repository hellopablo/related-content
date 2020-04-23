<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class GetStoreTest
 *
 * @package Tests\TestCases\EngineTest
 */
class GetStoreTest extends TestCase
{
    /** @var Interfaces\Store */
    static $oStore;

    /** @var Engine */
    static $oEngine;

    // --------------------------------------------------------------------------

    public static function setUpBeforeClass(): void
    {
        static::$oStore  = new Store\Ephemeral();
        static::$oEngine = new Engine(static::$oStore);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::getStore
     */
    public function test_returns_instance_of_store()
    {
        $this->assertSame(
            static::$oStore,
            static::$oEngine->getStore()
        );
    }
}
