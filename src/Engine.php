<?php

namespace HelloPablo\RelatedContentEngine;

use HelloPablo\RelatedContentEngine\Interfaces;

/**
 * Class Engine
 *
 * @package HelloPablo\RelatedContentEngine
 */
class Engine
{
    /**
     * The data store in use
     *
     * @var Interfaces\Store
     */
    protected $store;

    // --------------------------------------------------------------------------

    /**
     * Engine constructor.
     *
     * @param Interfaces\Store $store The data store to use
     */
    public function __construct(Interfaces\Store $store)
    {
        $this->store = $store;
        $this->store->connect();
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the instance of the store being used
     *
     * @return Interfaces\Store
     */
    public function getStore(): Interfaces\Store
    {
        return $this->store;
    }
}
