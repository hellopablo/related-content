<?php

namespace Tests\Traits;

use Tests\Mocks;

/**
 * Class Utilities
 *
 * @package Tests\Traits
 */
trait Utilities
{
    /**
     * Returns details about the test object: DataTypeOne1
     *
     * @return mixed[]
     */
    function getDataTypeOne1(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeOne();
        $object    = new Mocks\Objects\DataTypeOne1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    /**
     * Returns details about the test object: DataTypeOne2
     *
     * @return mixed[]
     */
    function getDataTypeOne2(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeOne();
        $object    = new Mocks\Objects\DataTypeOne2();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    /**
     * Returns details about the test object: DataTypeTwo1
     *
     * @return mixed[]
     */
    function getDataTypeTwo1(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeTwo();
        $object    = new Mocks\Objects\DataTypeTwo1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    /**
     * Returns details about the test object: DataTypeTwo2
     *
     * @return mixed[]
     */
    function getDataTypeTwo2(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeTwo();
        $object    = new Mocks\Objects\DataTypeTwo2();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    /**
     * Returns details about the test object: DataTypeThree1
     *
     * @return mixed[]
     */
    function getDataTypeThree1(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeThree();
        $object    = new Mocks\Objects\DataTypeThree1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }
}
