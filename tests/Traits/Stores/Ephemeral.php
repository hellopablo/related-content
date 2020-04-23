<?php

namespace Tests\Traits\Stores;

use Exception;
use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Store;

/**
 * Class Ephemeral
 *
 * @package Tests\Traits\Stores
 */
trait Ephemeral
{
    /**
     * Gets a store instance
     *
     * @param array $config
     *
     * @return Interfaces\Store
     * @throws Exception
     */
    protected function getStore(array $config = []): Interfaces\Store
    {
        $store = new Store\Ephemeral($config);
        $store->connect();

        return $store;
    }
}