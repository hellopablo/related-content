<?php

namespace HelloPablo\RelatedContent\Store;

use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Interfaces;
use HelloPablo\RelatedContent\Query;
use HelloPablo\RelatedContent\Relation;
use stdClass;

/**
 * Class Ephemeral
 *
 * @package HelloPablo\RelatedContent\Store
 */
class Ephemeral implements Interfaces\Store
{
    /**
     * The data store
     *
     * @var stdClass[]
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
     * @param mixed[] $config Config array as required by the driver
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
     * @throws NotConnectedException
     */
    public function connect(): Interfaces\Store
    {
        if (!$this->will_connect) {
            throw new NotConnectedException('Failed to connect to the store');
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
     * @return mixed[]
     * @throws NotConnectedException
     */
    public function dump(): array
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

        return $this->data;
    }

    // --------------------------------------------------------------------------

    /**
     * Deletes all data in the store
     *
     * @return $this
     * @throws NotConnectedException
     */
    public function empty(): Interfaces\Store
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

        $this->data = [];
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Reads data from the store
     *
     * @param string     $entity The entity type the ID belongs to
     * @param string|int $id     The item's ID
     *
     * @return Interfaces\Relation[]
     * @throws NotConnectedException
     */
    public function read(string $entity, $id): array
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

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
     * @throws NotConnectedException
     */
    public function write(string $entity, $id, array $relations): Interfaces\Store
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

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
     * @throws NotConnectedException
     */
    public function delete(string $entity, $id): Interfaces\Store
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

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
     * @param string                $sourceEntity    The source's entity
     * @param string|int            $sourceId        The source's ID
     * @param string[]              $restrict        An array of entity types to restrict to
     * @param int|null              $limit           The maximum number of results to return
     * @param int                   $offset          The query offset
     *
     * @return Query\Hit[]
     * @throws NotConnectedException
     */
    public function query(
        array $sourceRelations,
        string $sourceEntity,
        $sourceId,
        array $restrict = [],
        int $limit = null,
        int $offset = 0
    ): array {

        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        } elseif (empty($sourceRelations)) {
            return [];
        }

        $hits = [];

        foreach ($this->data as $datum) {

            foreach ($sourceRelations as $sourceRelation) {

                if (empty($restrict) || in_array($datum->entity, $restrict)) {

                    if ($datum->type === $sourceRelation->getType() && $datum->value === $sourceRelation->getValue()) {

                        if ($datum->entity === $sourceEntity && $datum->id === $sourceId) {
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
                new $hit->entity(),
                $hit->id,
                $resultMap[$key]
            );
        }

        return array_slice(array_values($results), $offset, $limit);
    }
}
