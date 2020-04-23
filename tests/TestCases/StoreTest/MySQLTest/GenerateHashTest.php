<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store\MySQL;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class GenerateHashTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class GenerateHashTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::generateHash
     * @throws Exception
     */
    public function test_generates_Correct_hash()
    {
        /** @var MySQL $store */
        $store = static::getStore();
        $this->assertEquals(
            md5('test::1'),
            $store->generateHash('test', 1)
        );
    }
}
