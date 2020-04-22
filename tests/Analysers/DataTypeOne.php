<?php

namespace Tests\Analysers;

use HelloPablo\RelatedContentEngine\Interfaces\Analyser;

class DataTypeOne implements Analyser
{
    public function analyse(object $item): array
    {
        return [];
    }
}
