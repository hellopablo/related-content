<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class SeedDataTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class SeedDataTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::__construct
     * @throws Exception
     */
    public function test_data_is_empty_if_not_seeded()
    {
        $store = new Store\Ephemeral();
        $store->connect();

        $data = $store->getConnection();

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
        $store = new Store\Ephemeral(['data' => ['test']]);
        $store->connect();

        $data  = $store->getConnection();
        $datum = reset($data);

        $this->assertIsArray($data);
        $this->assertCount(1, $data);
        $this->assertEquals('test', $datum);
    }
}
