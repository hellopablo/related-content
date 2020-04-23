<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Tests\Traits;

/**
 * Class DeleteTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class DeleteTest extends \Tests\TestCases\StoreTest\EphemeralTest\DeleteTest
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    public static function setUpBeforeClass(): void
    {
        static::dropTable();
    }
}
