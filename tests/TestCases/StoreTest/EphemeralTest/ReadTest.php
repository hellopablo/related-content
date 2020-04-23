<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class ReadTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class ReadTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_can_read_data()
    {
        $this->markTestIncomplete();
        $store = new Store\Ephemeral();
        $store->connect();
    }
}
