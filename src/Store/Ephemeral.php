<?php

namespace HelloPablo\RelatedContentEngine\Store;

use Exception;
use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Query;
use HelloPablo\RelatedContentEngine\Relation;

/**
 * Class Ephemeral
 *
 * @package HelloPablo\RelatedContentEngine\Store
 */
class Ephemeral implements Interfaces\Store
{
    /**
     * The data store
     *
     * @var array
     */
    public $data;

    /**
     * Whether the store will succeed in connecting
     *
     * @var bool
     */
    protected $will_connect = true;

    /**
     * Whether the store is connected (mainly used for testing)
     *
     * @var bool
     */
    protected $is_connected = false;

    // --------------------------------------------------------------------------

    /**
     * Ephemeral constructor.
     *
     * @param array $config Config array as required by the driver
     */
    public function __construct(array $config = [])
    {
        $this->data         = $config['data'] ?? [];
        $this->will_connect = $config['will_connect'] ?? true;
    }

    // --------------------------------------------------------------------------

    /**
     * Opens a connection to the store
     *
     * @return $this
     * @throws Exception
     */
    public function connect(): Interfaces\Store
    {
        if (!$this->will_connect) {
            throw new Exception('Failed to connect to the store');
        }

        $this->is_connected = true;
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
        return $this->is_connected;
    }

    // --------------------------------------------------------------------------

    /**
     * Disconnects the connection
     *
     * @return $this
     */
    public function disconnect(): Interfaces\Store
    {
        $this->is_connected = false;
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
        return $this->is_connected ? $this->data : null;
    }

    // --------------------------------------------------------------------------

    /**
     * Dumps the entire contents of the data store
     *
     * @return array
     */
    public function dump(): array
    {
        return $this->data;
    }

    // --------------------------------------------------------------------------

    /**
     * Reads data from the store
     *
     * @param string           $entity The entity type the ID belongs to
     * @param string|int|array $id     Filter by ID(s)
     *
     * @return Interfaces\Relation[]
     */
    public function read(string $entity, $id): array
    {
        $results = [];
        foreach ($this->data as $datum) {
            if ($datum->entity === $entity && $datum->id === $id) {
                $results[] = new Relation\Node(
                    $datum->type,
                    $datum->value
                );
            }
        }

        return $results;
    }

    // --------------------------------------------------------------------------

    /**
     * Writes relations to the store
     *
     * @param string                $entity    The entity type the ID belongs to
     * @param string|int            $id        The ID the relations belong to
     * @param Interfaces\Relation[] $relations Array of the relations
     *
     * @return $this
     */
    public function write(string $entity, $id, array $relations): Interfaces\Store
    {
        foreach ($relations as $relation) {
            $this->data[] = (object) [
                'entity' => $entity,
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
     * @param string     $entity The entity type the ID belongs to
     * @param string|int $id     The ID of the item to delete relations for
     *
     * @return $this
     */
    public function delete(string $entity, $id): Interfaces\Store
    {
        foreach ($this->data as &$datum) {
            if ($datum->entity === $entity && $datum->id === $id) {
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
     * @param Interfaces\Relation[] $sourceRelations The source's relations
     * @param string                $sourceType      The source's type
     * @param string|int            $sourceId        The source's ID
     * @param string[]              $restrict        An array of entity types to restrict to
     * @param int|null              $limit           The maximum number of results to return
     *
     * @return Query\Hit[]
     */
    public function query(
        array $sourceRelations,
        string $sourceType,
        $sourceId,
        array $restrict = [],
        int $limit = null
    ): array {

        if (empty($sourceRelations)) {
            return [];
        }

        $hits = [];

        foreach ($this->data as $datum) {

            foreach ($sourceRelations as $sourceRelation) {

                if (empty($restrict) || in_array($datum->entity, $restrict)) {

                    if ($datum->type === $sourceRelation->getType() && $datum->value === $sourceRelation->getValue()) {

                        if ($datum->entity === $sourceType && $datum->id === $sourceId) {
                            continue;
                        }

                        $hits[] = $datum;
                    }
                }
            }
        }

        $resultMap = [];
        foreach ($hits as $hit) {
            $key = $hit->entity . '::' . $hit->id;
            if (!array_key_exists($key, $resultMap)) {
                $resultMap[$key] = 0;
            }
            $resultMap[$key]++;
        }

        $results = [];
        foreach ($hits as $hit) {

            $key = $hit->entity . '::' . $hit->id;

            if (array_key_exists($key, $results)) {
                continue;
            }

            $results[$key] = new Query\Hit(
                $hit->entity,
                $hit->id,
                $resultMap[$key]
            );
        }

        return array_slice(array_values($results), 0, $limit);
    }
}
