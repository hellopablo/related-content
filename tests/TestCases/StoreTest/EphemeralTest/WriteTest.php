<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContentEngine\Exception\NotConnectedException;
use HelloPablo\RelatedContentEngine\Interfaces;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;

/**
 * Class WriteTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class WriteTest extends TestCase
{
    use Traits\Utilities;
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::write
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::write
     * @throws NotConnectedException
     */
    public function test_can_write_data(): void
    {
        $store = static::getStore();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->assertGreaterThan(0, count($relations));

        $store->write($entity, $id, $relations);

        $data = $store->dump();
        $this->assertCount(count($relations), $data);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::write
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::write
     * @throws NotConnectedException
     */
    public function test_method_returns_instance_of_store(): void
    {
        $store = static::getStore();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->assertGreaterThan(0, count($relations));

        $this->assertInstanceOf(
            Interfaces\Store::class,
            $store->write($entity, $id, $relations)
        );
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContentEngine\Store\Ephemeral::write
     * @covers \HelloPablo\RelatedContentEngine\Store\MySQL::write
     * @throws NotConnectedException
     */
    public function test_throws_exception_if_disconnected()
    {
        $store = static::getStore();
        $store->disconnect();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->expectException(Exception::class);
        $store->write($entity, $id, $relations);
    }
}
