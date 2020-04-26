<?php

namespace Tests\TestCases;

use ArgumentCountError;
use Exception;
use HelloPablo\RelatedContent\Engine;
use HelloPablo\RelatedContent\Store;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use TypeError;

/**
 * Class EngineTest
 *
 * @package Tests\TestCases
 */
class EngineTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContent\Engine::__construct
     */
    public function test_store_is_a_required_argument(): void
    {
        $this->expectException(ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new Engine();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::__construct
     */
    public function test_store_must_be_instance_of_store(): void
    {
        $this->expectException(TypeError::class);
        /** @phpstan-ignore-next-line */
        new Engine(null);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Engine::__construct
     */
    public function test_store_automatically_connects(): void
    {
        $store = new Store\Ephemeral([
            'will_connect' => false,
        ]);

        $this->expectException(Exception::class);
        new Engine($store);
    }
}
