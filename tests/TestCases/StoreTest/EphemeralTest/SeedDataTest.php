<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class SeedDataTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class SeedDataTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::__construct
     * @throws NotConnectedException
     */
    public function test_data_is_empty_if_not_seeded(): void
    {
        $store = static::getStore();
        $data  = $store->dump();

        static::assertIsArray($data);
        static::assertCount(0, $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::__construct
     * @throws NotConnectedException
     */
    public function test_can_seed_data(): void
    {
        $store = static::getStore(['seed' => true]);

        $data  = $store->dump();
        $datum = reset($data);

        static::assertIsArray($data);
        static::assertCount(1, $data);
        static::assertEquals('test', $datum);
    }
}
