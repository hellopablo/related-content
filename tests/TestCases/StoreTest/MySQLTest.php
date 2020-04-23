<?php

namespace Tests\TestCases\StoreTest;

use HelloPablo\RelatedContentEngine\Engine;
use HelloPablo\RelatedContentEngine\Store;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * Class MySQLTest
 *
 * @package Tests\TestCases\StoreTest
 */
class MySQLTest extends TestCase
{
    public function test_store_exists()
    {
        $this->assertTrue(class_exists(Store\MySQL::class));
    }

    // --------------------------------------------------------------------------

    public function test_mysql_credentials_are_set()
    {
        $this->assertNotEmpty(getenv('MYSQL_USER'));
        $this->assertNotEmpty(getenv('MYSQL_PASS'));
        $this->assertNotEmpty(getenv('MYSQL_DATABASE'));
    }
}
