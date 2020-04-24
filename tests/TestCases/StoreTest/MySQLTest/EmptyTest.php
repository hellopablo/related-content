<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use Tests\Traits;

/**
 * Class EmptyTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class EmptyTest extends \Tests\TestCases\StoreTest\EphemeralTest\EmptyTest
{
    use Traits\Stores\MySQL;
}
