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
    static $oStore;

    /** @var Engine */
    static $oEngine;

    // --------------------------------------------------------------------------

    /**
     * @throws NotConnectedException
     */
    public static function setUpBeforeClass(): void
    {
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

        $this->assertNotEmpty($data);
        $this->assertCount(1, $data);

        static::$oEngine->empty();

        $data = static::$oEngine->dump();
        $this->assertEmpty($data);
    }
}
