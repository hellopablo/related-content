<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class DeleteTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class DeleteTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::delete
     */
    public function test_can_delete_data()
    {
        $this->markTestIncomplete();
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::delete
     */
    public function test_deletes_data_for_item()
    {
        $this->markTestIncomplete();
    }
}
