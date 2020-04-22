<?php

namespace Tests\Mocks;

use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Query;

class Store implements Interfaces\Store
{
    public $data = [];

    // --------------------------------------------------------------------------

    /**
     * Mock constructor.
     *
     * @param array $config Config array as required by the driver
     */
    public function __construct(array $config)
    {
        //  Nothing to do
    }

    // --------------------------------------------------------------------------

    /**
     * Opens a connection to the store
     *
     * @return $this
     */
    public function connect(): Interfaces\Store
    {
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the connection is established or not
     *
     * @return bool
     */
    public function isConnected(): bool
    {
        return true;
    }

    // --------------------------------------------------------------------------

    /**
     * Disconnects the connection
     *
     * @return $this
     */
    public function disconnect(): Interfaces\Store
    {
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the store connection
     *
     * @return mixed
     */
    public function getConnection()
    {
        return null;
    }

    // --------------------------------------------------------------------------

    /**
     * Reads data from the store
     *
     * @param Interfaces\Analyser $analyser The analyser which was used
     * @param string|int|array    $id       Filter by ID(s)
     *
     * @return Interfaces\Relation[]
     */
    public function read(Interfaces\Analyser $analyser, $id): array
    {
        $results = [];
        foreach ($this->data as &$datum) {
            if ($datum->entity === get_class($analyser) && $datum->id === $id) {
                $results[] = $datum;
            }
        }

        return $results;
    }

    // --------------------------------------------------------------------------

    /**
     * Writes relations to the store
     *
     * @param Interfaces\Analyser   $analyser  The analyser which was used
     * @param string|int            $id        The ID the relations belong to
     * @param Interfaces\Relation[] $relations Array of the relations
     *
     * @return $this
     */
    public function write(Interfaces\Analyser $analyser, $id, array $relations): Interfaces\Store
    {
        foreach ($relations as $relation) {
            $this->data[] = (object) [
                'entity' => get_class($analyser),
                'id'     => $id,
                'type'   => $relation->getType(),
                'value'  => $relation->getValue(),
            ];
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Deletes relations from the store for an item
     *
     * @param Interfaces\Analyser $analyser The analyser which was used
     * @param string|int|null     $id       An ID to restrict the deletion to
     *
     * @return $this
     */
    public function delete(Interfaces\Analyser $analyser, $id): Interfaces\Store
    {
        foreach ($this->data as &$datum) {
            if ($datum->entity === get_class($analyser) && $datum->id === $id) {
                $datum = null;
            }
        }

        $this->data = array_values(array_filter($this->data));

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Queries the store to find related items
     *
     * @param string                $sourceType The source's entity type
     * @param string|int            $sourceId   The source's ID
     * @param Interfaces\Analyser[] $restrict   An array of analysers to restrict the result set to
     * @param int|null              $limit      The maximum number of results to return
     *
     * @return Query\Hit[]
     */
    public function query(
        string $sourceType,
        $sourceId,
        array $restrict = [],
        int $limit = null
    ): array {

        //  @todo (Pablo - 2020-04-22) - Implement this
        return [];
    }
}
