<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use PHPUnit\Framework\TestCase;
use Tests\Traits;

/**
 * Class EmptyTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class EmptyTest extends TestCase
{
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::empty
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::empty
     * @throws Exception
     */
    public function test_can_empty_store(): void
    {
        $store = static::getStore(['seed' => true]);

        $data = $store->dump();
        $this->assertNotEmpty($data);
        $this->assertCount(1, $data);

        $store->empty();

        $data = $store->dump();
        $this->assertEmpty($data);
    }
}
