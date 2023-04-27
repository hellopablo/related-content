<?php

namespace HelloPablo\RelatedContent;

use HelloPablo\RelatedContent\Interfaces;

/**
 * Class Factory
 *
 * @package HelloPablo\RelatedContent
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
    ): Engine {
        return new Engine($store);
    }
}
