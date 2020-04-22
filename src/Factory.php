<?php

namespace HelloPablo\RelatedContentEngine;

use HelloPablo\RelatedContentEngine\Interfaces;

/**
 * Class Factory
 *
 * @package HelloPablo\RelatedContentEngine
 */
class Factory
{
    /**
     * Creates a new instance of the Engine
     *
     * @param Interfaces\Store $store The data store to use
     *
     * @return Engine
     */
    public static function build(
        Interfaces\Store $store
    ) {
        return new Engine($store);
    }
}
