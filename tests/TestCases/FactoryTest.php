<?php

namespace Tests\TestCases;

use ArgumentCountError;
use HelloPablo\RelatedContent\Engine;
use HelloPablo\RelatedContent\Factory;
use HelloPablo\RelatedContent\Store;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class FactoryTest
 *
 * @package Tests\TestCases
 */
class FactoryTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContent\Factory::build
     */
    public function test_build_returns_instance_of_engine(): void
    {
        $engine = Factory::build(new Store\Ephemeral());
        static::assertInstanceOf(Engine::class, $engine);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Factory::build
     */
    public function test_store_is_a_required_argument(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        Factory::build();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Factory::build
     */
    public function test_store_must_be_instance_of_store(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        Factory::build(null);
    }
}
