<?php

namespace Tests\TestCases\EngineTest;

use HelloPablo\RelatedContent\Engine;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Interfaces;
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
     * @covers \HelloPablo\RelatedContent\Engine::index
     */
    public function test_can_dump_store_contents(): void
    {
        $data = static::$oEngine->dump();
        static::assertCount(0, $data);

        static::$oEngine->index(
            new Mocks\Objects\DataTypeOne1(),
            new Mocks\Analysers\DataTypeOne()
        );

        $data = static::$oEngine->dump();
        static::assertCount(3, $data);
    }
}
