<?php

namespace Tests\TestCases\StoreTest;

use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;

/**
 * Class MySQLTest
 *
 * @package Tests\TestCases\StoreTest
 */
class MySQLTest extends TestCase
{
    public function test_store_exists(): void
    {
        static::assertTrue(class_exists(Store\MySQL::class));
    }

    // --------------------------------------------------------------------------

    public function test_mysql_credentials_are_set(): void
    {
        static::assertNotEmpty(getenv('MYSQL_USER'));
        static::assertNotEmpty(getenv('MYSQL_PASS'));
        static::assertNotEmpty(getenv('MYSQL_DATABASE'));
    }
}
