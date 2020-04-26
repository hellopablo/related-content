<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContent\Engine;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Interfaces;
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
     * @covers \HelloPablo\RelatedContent\Engine::getStore
     */
    public function test_returns_instance_of_store(): void
    {
        static::assertSame(
            static::$oStore,
            static::$oEngine->getStore()
        );
    }
}
