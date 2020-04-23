<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class ReadTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class ReadTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::read
     */
    public function test_can_read_data()
    {
        $this->markTestIncomplete();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::read
     */
    public function test_read_returns_data_for_requested_item_only()
    {
        $this->markTestIncomplete();
    }
}
