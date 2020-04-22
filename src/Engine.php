<?php

namespace HelloPablo\RelatedContentEngine;

use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Query;

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
     * Returns all relationships for an item
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

    // --------------------------------------------------------------------------

    /**
     * Returns matching items from the data store sorted by score
     *
     * @param object              $source   The source object
     * @param Interfaces\Analyser $analyser The source's analyser
     * @param array               $restrict An array of analysers to limit the result set to
     * @param int                 $limit    The maximum number of results to return
     *
     * @return Query\Hit[];
     */
    public function query(object $source, Interfaces\Analyser $analyser, array $restrict = [], int $limit = null): array
    {
        return $this->store
            ->query(
                get_class($analyser),
                $analyser->getId($source),
                $restrict,
                $limit
            );
    }
}
