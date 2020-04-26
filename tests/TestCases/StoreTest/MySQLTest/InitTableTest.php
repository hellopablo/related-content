<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use HelloPablo\RelatedContent\Exception\MissingExtension;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Store;
use Tests\Traits;
use PHPUnit\Framework\TestCase;

/**
 * Class InitTableTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class InitTableTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\MySQL::test
     * @covers \HelloPablo\RelatedContent\Store\MySQL::initTable
     * @throws NotConnectedException
     * @throws MissingExtension
     */
    public function test_creates_table_on_connect(): void
    {
        $pdo = static::getDb();

        $pdo->query('DROP TABLE IF EXISTS `' . Store\MySQL::DEFAULT_TABLE . '`;');

        $query = $pdo->query('SHOW TABLES LIKE \'' . Store\MySQL::DEFAULT_TABLE . '\';');
        static::assertEquals(0, $query->rowCount());

        static::getStore();

        $query = $pdo->query('SHOW TABLES LIKE \'' . Store\MySQL::DEFAULT_TABLE . '\';');
        static::assertEquals(1, $query->rowCount());

        $pdo->query('DROP TABLE IF EXISTS `' . Store\MySQL::DEFAULT_TABLE . '`;');
    }
}
