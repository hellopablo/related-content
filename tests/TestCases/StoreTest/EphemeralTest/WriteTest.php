<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class WriteTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class WriteTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_can_write_data()
    {
        $this->markTestIncomplete();
        $store = new Store\Ephemeral();
        $store->connect();
    }
}
