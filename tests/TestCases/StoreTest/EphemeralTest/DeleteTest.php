<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class DeleteTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class DeleteTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_can_delete_data()
    {
        $this->markTestIncomplete();
        $store = new Store\Ephemeral();
        $store->connect();
    }
}
