<?php

namespace Tests\Traits\Stores;

use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Interfaces;
use HelloPablo\RelatedContent\Store;

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
     * @param mixed[] $config
     *
     * @return Interfaces\Store
     * @throws NotConnectedException
     */
    protected static function getStore(array $config = []): Interfaces\Store
    {
        //  Seed one record if required
        if (array_key_exists('seed', $config)) {
            unset($config['seed']);
            $config['data'] = ['test'];
        }

        $store = new Store\Ephemeral($config);
        $store->connect();

        return $store;
    }
}
