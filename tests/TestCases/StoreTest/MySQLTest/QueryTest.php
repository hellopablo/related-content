<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class QueryTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class QueryTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::query
     */
    public function test_can_query_data()
    {
        $this->markTestIncomplete();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::query
     */
    public function test_returns_related_items_of_type()
    {
        $this->markTestIncomplete();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::query
     */
    public function test_returns_limited_number_of_related_items()
    {
        $this->markTestIncomplete();
    }
}
