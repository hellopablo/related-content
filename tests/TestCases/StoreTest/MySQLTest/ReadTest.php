<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Tests\Traits;

/**
 * Class ReadTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class ReadTest extends \Tests\TestCases\StoreTest\EphemeralTest\ReadTest
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    public static function setUpBeforeClass(): void
    {
        static::dropTable();
    }
}
