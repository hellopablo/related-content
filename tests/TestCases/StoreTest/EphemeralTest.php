<?php

namespace Tests\TestCases\StoreTest;

use HelloPablo\RelatedContentEngine\Store;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;

/**
 * Class EphemeralTest
 *
 * @package Tests\TestCases\StoreTest
 */
class EphemeralTest extends TestCase
{
    public function test_store_exists(): void
    {
        $this->assertTrue(class_exists(Store\Ephemeral::class));
    }
}
