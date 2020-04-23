<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
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
     * @throws Exception
     */
    public function test_data_is_empty_if_not_seeded()
    {
        $store = static::getStore();
        $data  = $store->dump();

        $this->assertIsArray($data);
        $this->assertCount(0, $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::__construct
     * @throws Exception
     */
    public function test_can_seed_data()
    {
        $store = static::getStore(['data' => ['test']]);

        $data  = $store->dump();
        $datum = reset($data);

        $this->assertIsArray($data);
        $this->assertCount(1, $data);
        $this->assertEquals('test', $datum);
    }
}
