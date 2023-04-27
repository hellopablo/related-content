<?php

namespace Tests\Mocks\Analysers;

use HelloPablo\RelatedContent\Interfaces;
use HelloPablo\RelatedContent\Relation;

/**
 * Class DataTypeOne
 *
 * @package Tests\Analysers
 */
class DataTypeOne implements Interfaces\Analyser
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

        foreach ($item->topics as $topic) {
            $nodes[] = new Relation\Node('TOPIC', $topic);
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
    public function getId(object $item): mixed
    {
        return $item->id;
    }
}
