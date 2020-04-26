<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use HelloPablo\RelatedContentEngine\Interfaces;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class EmptyTest
 *
 * @package Tests\TestCases\EngineTest
 */
class EmptyTest extends TestCase
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
        static::$oStore  = static::getStore(['seed' => true]);
        static::$oEngine = new Engine(static::$oStore);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::empty
     */
    public function test_can_empty_store(): void
    {
        $data = static::$oEngine->dump();

        static::assertNotEmpty($data);
        static::assertCount(1, $data);

        static::$oEngine->empty();

        $data = static::$oEngine->dump();
        static::assertEmpty($data);
    }
}
