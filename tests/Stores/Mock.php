<?php

namespace Tests\Stores;

use HelloPablo\RelatedContentEngine\Interfaces\Store;

class Mock implements Store
{
    protected $cache = [];

    // --------------------------------------------------------------------------

    public function __construct(array $config)
    {
        //  Nothing to do
    }

    // --------------------------------------------------------------------------

    public function connect(): Store
    {
        return $this;
    }

    // --------------------------------------------------------------------------

    public function isConnected(): bool
    {
        return true;
    }

    // --------------------------------------------------------------------------

    public function disconnect(): Store
    {
        return $this;
    }

    // --------------------------------------------------------------------------

    public function getConnection()
    {
        return null;
    }

    // --------------------------------------------------------------------------

    public function read(): Store
    {
        // TODO: Implement read() method.
        return $this;
    }

    // --------------------------------------------------------------------------

    public function write(array $relations): Store
    {
        $this->cache = array_merge($this->cache, $relations);
        return $this;
    }

    // --------------------------------------------------------------------------

    public function delete(array $relations): Store
    {
        // TODO: Implement delete() method.
        return $this;
    }
}
