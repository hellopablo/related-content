<?php

namespace Tests\Mocks\Analysers;

use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Relation;

/**
 * Class DataTypeThree
 *
 * @package Tests\Analysers
 */
class DataTypeThree implements Interfaces\Analyser
{
    /**
     * Analyses an item and returns an array of Relations
     *
     * @param object $item The item to analyse
     *
     * @return Interfaces\Relation[]
     */
    public function analyse(object $item): array
    {
        $nodes = [];

        foreach ($item->categories as $category) {
            $nodes[] = new Relation\Node('CATEGORY', $category);
        }

        return $nodes;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the item's unique identifier
     *
     * @param object $item
     *
     * @return mixed
     */
    public function getId(object $item)
    {
        return $item->id;
    }
}
