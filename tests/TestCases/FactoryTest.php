<?php

namespace Tests\TestCases;

use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Factory;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;

/**
 * Class FactoryTest
 *
 * @package Tests\TestCases
 */
class FactoryTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Factory::build
     */
    public function test_build_returns_instance_of_engine()
    {
        $engine = Factory::build(new Mocks\Store([]));
        $this->assertInstanceOf(Engine::class, $engine);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Factory::build
     */
    public function test_store_is_a_required_argument()
    {
        $this->expectException(\ArgumentCountError::class);
        Factory::build();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Factory::build
     */
    public function test_store_must_be_instance_of_store()
    {
        $this->expectException(\TypeError::class);
        Factory::build(null);
    }
}
