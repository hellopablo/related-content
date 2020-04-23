<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class QueryTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class QueryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_can_query_data()
    {
        $this->markTestIncomplete();
        $store = new Store\Ephemeral();
        $store->connect();
    }
}
