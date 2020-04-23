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
    function getDataTypeOne1(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeOne();
        $object    = new Mocks\Objects\DataTypeOne1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    function getDataTypeOne2(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeOne();
        $object    = new Mocks\Objects\DataTypeOne2();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    function getDataTypeTwo1(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeTwo();
        $object    = new Mocks\Objects\DataTypeTwo1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    function getDataTypeTwo2(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeTwo();
        $object    = new Mocks\Objects\DataTypeTwo2();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }

    // --------------------------------------------------------------------------

    function getDataTypeThree1(): array
    {
        $analyser  = new Mocks\Analysers\DataTypeThree();
        $object    = new Mocks\Objects\DataTypeThree1();
        $id        = $analyser->getId($object);
        $relations = $analyser->analyse($object);

        return [get_class($analyser), $object, $id, $relations];
    }
}
