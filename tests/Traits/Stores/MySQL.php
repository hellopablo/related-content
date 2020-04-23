<?php

namespace Tests\Traits\Stores;

use Exception;
use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Store;

/**
 * Class MySQL
 *
 * @package Tests\Traits\Stores
 */
trait MySQL
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
        $store = new Store\MySQL($config);
        $store->connect();

        return $store;
    }
}
