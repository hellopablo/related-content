<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Exception;
use HelloPablo\RelatedContentEngine\Store;
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
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::test
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::initTable
     * @throws Exception
     */
    public function test_creates_table_on_connect()
    {
        $pdo = static::getDb();

        $pdo->query('DROP TABLE IF EXISTS `' . Store\MySQL::DEFAULT_TABLE . '`;');

        $query = $pdo->query('SHOW TABLES LIKE \'' . Store\MySQL::DEFAULT_TABLE . '\';');
        $this->assertEquals(0, $query->rowCount());

        $this->getStore();

        $query = $pdo->query('SHOW TABLES LIKE \'' . Store\MySQL::DEFAULT_TABLE . '\';');
        $this->assertEquals(1, $query->rowCount());

        $pdo->query('DROP TABLE IF EXISTS `' . Store\MySQL::DEFAULT_TABLE . '`;');
    }
}
