<?php

namespace HelloPablo\RelatedContentEngine;

use HelloPablo\RelatedContentEngine\Interfaces\Store;

class Engine
{
    /**
     * The data store in use
     *
     * @var Store
     */
    protected $store;

    // --------------------------------------------------------------------------

    /**
     * Engine constructor.
     *
     * @param Store $store The data store to use
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
        $this->store->connect();
    }
}
