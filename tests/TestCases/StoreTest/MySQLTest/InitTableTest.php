<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use HelloPablo\RelatedContentEngine\Store\MySQL;
use PHPUnit\Framework\TestCase;
use Tests\TestCases\StoreTest\MySQLTest;

/**
 * Class InitTableTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class InitTableTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::test
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::initTable
     */
    public function test_creates_table_on_connect()
    {
        $pdo = MySQLTest::getDb();

        $pdo->query('DROP TABLE IF EXISTS `' . MySQL::DEFAULT_TABLE . '`;');

        $query = $pdo->query('SHOW TABLES LIKE \'' . MySQL::DEFAULT_TABLE . '\';');
        $this->assertEquals(0, $query->rowCount());

        $store = MySQLTest::getStore();
        $store->connect();

        $query = $pdo->query('SHOW TABLES LIKE \'' . MySQL::DEFAULT_TABLE . '\';');
        $this->assertEquals(1, $query->rowCount());

        $pdo->query('DROP TABLE IF EXISTS `' . MySQL::DEFAULT_TABLE . '`;');
    }
}
