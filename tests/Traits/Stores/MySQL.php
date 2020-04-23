<?php

namespace Tests\Traits\Stores;

use Exception;
use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Store;
use PDO;

/**
 * Class MySQL
 *
 * @package Tests\Traits\Stores
 */
trait MySQL
{
    /**
     * Gets a store instance
     *
     * @param array $config
     *
     * @return Interfaces\Store
     * @throws Exception
     */
    protected function getStore(array $config = []): Interfaces\Store
    {
        $store = new Store\MySQL([
            'user'     => getenv('MYSQL_USER'),
            'pass'     => getenv('MYSQL_PASS'),
            'database' => getenv('MYSQL_DATABASE'),
        ]);
        $store->connect();

        return $store;
    }

    // --------------------------------------------------------------------------

    protected static function getDb()
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

    protected static function dropTable()
    {
        $pdo = static::getDb();
        $pdo->query('DROP TABLE IF EXISTS ' . Store\MySQL::DEFAULT_TABLE);
    }
}
