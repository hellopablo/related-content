<?php

namespace Tests\TestCases\StoreTest\EphemeralTest;

use Exception;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use PHPUnit\Framework\TestCase;
use Tests\Mocks;
use Tests\Traits;

/**
 * Class QueryTest
 *
 * @package Tests\TestCases\StoreTest\EphemeralTest
 */
class QueryTest extends TestCase
{
    use Traits\Utilities;
    use Traits\Stores\Ephemeral;

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::query
     * @covers \HelloPablo\RelatedContent\Store\MySQL::query
     * @throws NotConnectedException
     */
    public function test_can_query_data(): void
    {
        $store = static::getStore();

        [$dt1entity, $dt1object1, $dt1id1, $dt1relations1] = $this->getDataTypeOne1();
        [$dt1entity, $dt1object2, $dt1id2, $dt1relations2] = $this->getDataTypeOne2();
        [$dt2entity, $dt2object1, $dt2id1, $dt2relations1] = $this->getDataTypeTwo1();
        [$dt2entity, $dt2object2, $dt2id2, $dt2relations2] = $this->getDataTypeTwo2();
        [$dt3entity, $dt3object1, $dt3id1, $dt3relations1] = $this->getDataTypeThree1();

        $store
            ->write($dt1entity, $dt1id1, $dt1relations1)
            ->write($dt1entity, $dt1id2, $dt1relations2)
            ->write($dt2entity, $dt2id1, $dt2relations1)
            ->write($dt2entity, $dt2id2, $dt2relations2)
            ->write($dt3entity, $dt3id1, $dt3relations1);

        // Testing (1); expecting 1 hit
        $hits = $store
            ->query(
                $dt1relations1,
                $dt1entity,
                $dt1id1
            );

        static::assertCount(1, $hits);

        // Testing (2); expecting 3 hits
        $hits = $store
            ->query(
                $dt1relations2,
                $dt1entity,
                $dt1id2
            );

        static::assertCount(3, $hits);

        // Testing (3); expecting 3 hits
        $hits = $store
            ->query(
                $dt2relations1,
                $dt2entity,
                $dt2id1
            );

        static::assertCount(3, $hits);

        // Testing (4); expecting 2 hits
        $hits = $store
            ->query(
                $dt2relations2,
                $dt2entity,
                $dt2id2
            );

        static::assertCount(2, $hits);

        // Testing (4); expecting 1 hit1
        $hits = $store
            ->query(
                $dt3relations1,
                $dt3entity,
                $dt3id1
            );

        static::assertCount(1, $hits);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::query
     * @covers \HelloPablo\RelatedContent\Store\MySQL::query
     * @throws NotConnectedException
     */
    public function test_returns_related_items_of_type(): void
    {
        $store = static::getStore();

        [$dt1entity, $dt1object1, $dt1id1, $dt1relations1] = $this->getDataTypeOne1();
        [$dt1entity, $dt1object2, $dt1id2, $dt1relations2] = $this->getDataTypeOne2();
        [$dt2entity, $dt2object1, $dt2id1, $dt2relations1] = $this->getDataTypeTwo1();
        [$dt2entity, $dt2object2, $dt2id2, $dt2relations2] = $this->getDataTypeTwo2();
        [$dt3entity, $dt3object1, $dt3id1, $dt3relations1] = $this->getDataTypeThree1();

        $store
            ->write($dt1entity, $dt1id1, $dt1relations1)
            ->write($dt1entity, $dt1id2, $dt1relations2)
            ->write($dt2entity, $dt2id1, $dt2relations1)
            ->write($dt2entity, $dt2id2, $dt2relations2)
            ->write($dt3entity, $dt3id1, $dt3relations1);

        $hits = $store
            ->query(
                $dt2relations1,
                $dt2entity,
                $dt2id1,
                [
                    $dt2entity,
                ]
            );

        $hit = reset($hits);

        static::assertCount(1, $hits);
        static::assertInstanceOf(Mocks\Analysers\DataTypeTwo::class, $hit->getAnalyser());
        static::assertEquals(2, $hit->getId());
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::query
     * @covers \HelloPablo\RelatedContent\Store\MySQL::query
     * @throws NotConnectedException
     */
    public function test_returns_limited_number_of_related_items(): void
    {
        $store = static::getStore();

        [$dt1entity, $dt1object1, $dt1id1, $dt1relations1] = $this->getDataTypeOne1();
        [$dt1entity, $dt1object2, $dt1id2, $dt1relations2] = $this->getDataTypeOne2();
        [$dt2entity, $dt2object1, $dt2id1, $dt2relations1] = $this->getDataTypeTwo1();
        [$dt2entity, $dt2object2, $dt2id2, $dt2relations2] = $this->getDataTypeTwo2();
        [$dt3entity, $dt3object1, $dt3id1, $dt3relations1] = $this->getDataTypeThree1();

        $store
            ->write($dt1entity, $dt1id1, $dt1relations1)
            ->write($dt1entity, $dt1id2, $dt1relations2)
            ->write($dt2entity, $dt2id1, $dt2relations1)
            ->write($dt2entity, $dt2id2, $dt2relations2)
            ->write($dt3entity, $dt3id1, $dt3relations1);

        $hits = $store
            ->query(
                $dt2relations1,
                $dt2entity,
                $dt2id1
            );

        static::assertCount(3, $hits);

        $hits = $store
            ->query(
                $dt2relations1,
                $dt2entity,
                $dt2id1,
                [],
                2
            );

        static::assertCount(2, $hits);
    }

    // --------------------------------------------------------------------------

    /**
     * @covers \HelloPablo\RelatedContent\Store\Ephemeral::query
     * @covers \HelloPablo\RelatedContent\Store\MySQL::query
     * @throws NotConnectedException
     */
    public function test_throws_exception_if_disconnected()
    {
        $store = static::getStore();
        $store->disconnect();

        [$entity, $object, $id, $relations] = $this->getDataTypeOne1();

        $this->expectException(Exception::class);
        $store->query($relations, $entity, $id);
    }
}
