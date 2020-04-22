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

    // --------------------------------------------------------------------------

    /**
     * Indexes an item into the data store
     *
     * @param object              $item     The item to index
     * @param Interfaces\Analyser $analyser The analyser to use
     *
     * @return $this
     */
    public function index(object $item, Interfaces\Analyser $analyser): self
    {
        $relations = $analyser->analyse($item);
        $id        = $analyser->getId($item);

        $this->store
            ->delete($analyser, $id)
            ->write($analyser, $id, $relations);

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Deletes all relationships for an item
     *
     * @param object              $item     The item being deleted
     * @param Interfaces\Analyser $analyser The analyser to use
     *
     * @return $this
     */
    public function delete(object $item, Interfaces\Analyser $analyser): self
    {
        $this->store
            ->delete(
                $analyser,
                $analyser->getId($item)
            );

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns  all relationships for an item
     *
     * @param object              $item     The item being read
     * @param Interfaces\Analyser $analyser The analyser to use
     *
     * @return Interfaces\Relation[]
     */
    public function read(object $item, Interfaces\Analyser $analyser): array
    {
        return $this->store
            ->read(
                $analyser,
                $analyser->getId($item)
            );
    }
}
