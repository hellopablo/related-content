<?php

namespace HelloPablo\RelatedContentEngine;

use HelloPablo\RelatedContentEngine\Interfaces\Store;

class Factory
{
    /**
     * Creates a new instance of the RelatedContentEngine
     *
     * @param Store $store The data store to use
     *
     * @return Engine
     */
    public static function build(
        Store $store
    ) {
        return new Engine($store);
    }
}
