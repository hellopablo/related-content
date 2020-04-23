<?php

namespace Tests\TestCases\EngineTest;

use Exception;
use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Interfaces;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;

/**
 * Class DumpTest
 *
 * @package Tests\TestCases\EngineTest
 */
class DumpTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /** @var Interfaces\Store */
    static $oStore;

    /** @var Engine */
    static $oEngine;

    // --------------------------------------------------------------------------

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        static::$oStore  = static::getStore();
        static::$oEngine = new Engine(static::$oStore);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Engine::index
     */
    public function test_can_dump_store_contents()
    {
        $data = static::$oEngine->dump();
        $this->assertCount(0, $data);

        static::$oEngine->index(
            new Mocks\Objects\DataTypeOne1(),
            new Mocks\Analysers\DataTypeOne()
        );

        $data = static::$oEngine->dump();
        $this->assertCount(3, $data);
    }
}
