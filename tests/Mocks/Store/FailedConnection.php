<?php

namespace Tests\Mocks\Store;

use HelloPablo\RelatedContentEngine\Interfaces;
use Tests\Mocks\Store;

class FailedConnection extends Store
{
    public function connect(): Interfaces\Store
    {
        throw new \Exception('Failed to connect');
    }
}
