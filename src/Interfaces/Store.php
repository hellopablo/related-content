<?php

namespace HelloPablo\RelatedContent\Interfaces;

use HelloPablo\RelatedContent\Query;

/**
 * Interface Store
 *
 * @package HelloPablo\RelatedContent\Interfaces
 */
interface Store
{
    /**
     * Store constructor.
     *
     * @param mixed[] $config Config array as required by the driver
     */
    public function __construct(array $config = []);

    // --------------------------------------------------------------------------

    /**
     * Opens a connection to the store
     *
     * @return $this
     */
    public function connect(): self;

    // --------------------------------------------------------------------------

    /**
     * Returns whether the connection is established or not
     *
     * @return bool
     */
    public function isConnected(): bool;

    // --------------------------------------------------------------------------

    /**
     * Disconnects the connection
     *
     * @return $this
     */
    public function disconnect(): self;

    // --------------------------------------------------------------------------

    /**
     * Returns the store connection
     *
     * @return mixed
     */
    public function getConnection();

    // --------------------------------------------------------------------------

    /**
     * Dumps the entire contents of the data store
     *
     * @return mixed[]
     */
    public function dump(): array;

    // --------------------------------------------------------------------------

    /**
     * Deletes all data in the store
     *
     * @return $this
     */
    public function empty(): self;

    // --------------------------------------------------------------------------

    /**
     * Reads data from the store
     *
     * @param string     $entity The entity type the ID belongs to
     * @param string|int $id     The item's ID
     *
     * @return Relation[]
     */
    public function read(string $entity, $id): array;

    // --------------------------------------------------------------------------

    /**
     * Writes relations to the store
     *
     * @param string     $entity    The entity type the ID belongs to
     * @param string|int $id        The ID the relations belong to
     * @param Relation[] $relations Array of the relations
     *
     * @return $this
     */
    public function write(string $entity, $id, array $relations): self;

    // --------------------------------------------------------------------------

    /**
     * Deletes relations from the store
     *
     * @param string     $entity The entity type the ID belongs to
     * @param string|int $id     The ID of the item to delete relations for
     *
     * @return $this
     */
    public function delete(string $entity, $id): self;

    // --------------------------------------------------------------------------

    /**
     * Queries the store to find related items
     *
     * @param Relation[] $sourceRelations The source's relations
     * @param string     $sourceEntity    The source's entity
     * @param string|int $sourceId        The source's ID
     * @param string[]   $restrict        An array of entity types to restrict to
     * @param int|null   $limit           The maximum number of results to return
     *
     * @return Query\Hit[]
     */
    public function query(
        array $sourceRelations,
        string $sourceEntity,
        $sourceId,
        array $restrict = [],
        int $limit = null
    ): array;
}
