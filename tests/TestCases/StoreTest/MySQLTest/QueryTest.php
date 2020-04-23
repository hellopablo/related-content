<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Tests\Traits;

/**
 * Class QueryTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class QueryTest extends \Tests\TestCases\StoreTest\EphemeralTest\QueryTest
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    public static function setUpBeforeClass(): void
    {
        static::dropTable();
    }
}
