<?php

namespace Tests\TestCases\StoreTest\MySQLTest;

use HelloPablo\RelatedContent\Exception\MissingExtension;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Store\MySQL;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class GenerateHashTest
 *
 * @package Tests\TestCases\StoreTest\MySQLTest
 */
class GenerateHashTest extends TestCase
{
    use Traits\Stores\MySQL;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\MySQL::generateHash
     * @throws NotConnectedException
     * @throws MissingExtension
     */
    public function test_generates_Correct_hash(): void
    {
        /** @var MySQL $store */
        $store = static::getStore();
        static::assertEquals(
            md5('test::1'),
            $store->generateHash('test', 1)
        );
    }
}
