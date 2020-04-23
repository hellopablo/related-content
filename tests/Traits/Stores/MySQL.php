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
     * @param mixed[] $config
     *
     * @return Interfaces\Store
     * @throws Exception
     */
    protected static function getStore(array $config = []): Interfaces\Store
    {
        static::dropTable();
        $store = new Store\MySQL([
            'user'     => getenv('MYSQL_USER'),
            'pass'     => getenv('MYSQL_PASS'),
            'database' => getenv('MYSQL_DATABASE'),
        ]);
        $store->connect();

        //  Seed one record if required
        if (array_key_exists('seed', $config)) {

            $statement = static::getDb()
                ->prepare(
                    sprintf(
                        'INSERT INTO %s (hash, entity, type, value) VALUES (:hash, :entity, :type, :value)',
                        Store\MySQL::DEFAULT_TABLE
                    )
                );
            $statement
                ->execute([
                    'hash'   => 'test',
                    'entity' => 'test',
                    'type'   => 'test',
                    'value'  => 'test',
                ]);
        }

        return $store;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a connected PDO instance
     *
     * @return PDO
     */
    protected static function getDb(): PDO
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

    /**
     * Drops the relations table
     */
    protected static function dropTable(): void
    {
        $pdo = static::getDb();
        $pdo->query('DROP TABLE IF EXISTS ' . Store\MySQL::DEFAULT_TABLE);
    }
}
