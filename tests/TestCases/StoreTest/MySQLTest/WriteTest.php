<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class WriteTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class WriteTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::write
     */
    public function test_can_write_data()
    {
        $this->markTestIncomplete();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::write
     */
    public function test_method_returns_instance_of_store()
    {
        $this->markTestIncomplete();
    }
}
