<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use HelloPablo\RelatedContentEngine\Interfaces;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class GetStoreTest
 *
 * @package Tests\TestCases\EngineTest
 */
class GetStoreTest extends TestCase
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
     * @covers \HelloPablo\RelatedContentEngine\Engine::getStore
     */
    public function test_returns_instance_of_store(): void
    {
        $this->assertSame(
            static::$oStore,
            static::$oEngine->getStore()
        );
    }
}
