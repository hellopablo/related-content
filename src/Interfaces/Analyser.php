<?php

namespace HelloPablo\RelatedContent\Interfaces;

/**
 * Interface Analyser
 *
 * @package HelloPablo\RelatedContent\Interfaces
 */
interface Analyser
{
    /**
     * Analyses an item and returns an array of Relations
     *
     * @param object $item The item to analyse
     *
     * @return Relation[]
     */
    public function analyse(object $item): array;

    // --------------------------------------------------------------------------

    /**
     * Returns the item's unique identifier
     *
     * @param object $item
     *
     * @return mixed
     */
    public function getId(object $item): mixed;
}
