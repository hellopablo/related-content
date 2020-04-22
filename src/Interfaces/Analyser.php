<?php

namespace HelloPablo\RelatedContentEngine\Interfaces;

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
}
