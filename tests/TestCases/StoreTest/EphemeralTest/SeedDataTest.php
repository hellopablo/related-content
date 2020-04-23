<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use PHPUnit\Framework\TestCase;
use Tests\TestCases\StoreTest\MySQLTest;

/**
 * Class SeedDataTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class SeedDataTest extends TestCase
{
    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::__construct
     */
    public function test_fails_to_connect_with_bad_credentials()
    {
        $this->markTestIncomplete();
    }
}
