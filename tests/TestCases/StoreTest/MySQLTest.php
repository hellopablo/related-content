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
    /**
     * Returns a configured instance of the MySQL store
     *
     * @param bool $validCredentials Whether to configure the store with valid credentials
     *
     * @return Store\MySQL
     */
    public static function getStore(bool $validCredentials = true)
    {
        return new Store\MySQL([
            'user'     => $validCredentials ? getenv('MYSQL_USER') : null,
            'pass'     => $validCredentials ? getenv('MYSQL_PASS') : null,
            'database' => $validCredentials ? getenv('MYSQL_DATABASE') : null,
        ]);
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a connection to the test DB
     *
     * @return PDO
     */
    public static function getDb()
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            Store\MySQL::DEFAULT_HOST,
            getenv('MYSQL_DATABASE'),
            Store\MySQL::DEFAULT_CHARSET
        );

        return new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASS'), Store\MySQL::DEFAULT_PDO_OPTIONS);
    }

    // --------------------------------------------------------------------------

    public function test_mysql_credentials_are_set()
    {
        $this->assertNotEmpty(getenv('MYSQL_USER'));
        $this->assertNotEmpty(getenv('MYSQL_PASS'));
        $this->assertNotEmpty(getenv('MYSQL_DATABASE'));
    }

    // --------------------------------------------------------------------------

    public function test_store_exists()
    {
        $this->assertTrue(class_exists(Store\MySQL::class));
    }
}
