<?php

namespace HelloPablo\RelatedContentEngine\Interfaces;

/**
 * Interface Store
 *
 * @package HelloPablo\RelatedContentEngine\Interfaces
 */
interface Store
{
    /**
     * Store constructor.
     *
     * @param array $config Config array as required by the driver
     */
    public function __construct(array $config);

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
     * Reads data from the store
     *
     * @param Analyser         $analyser The analyser which was used
     * @param string|int|array $id       Filter by ID(s)
     *
     * @return Relation[]
     */
    public function read(Analyser $analyser, $id): array;

    // --------------------------------------------------------------------------

    /**
     * Writes relations to the store
     *
     * @param Analyser   $analyser  The analyser which was used
     * @param string|int $id        The ID the relations belong to
     * @param Relation[] $relations Array of the relations
     *
     * @return $this
     */
    public function write(Analyser $analyser, $id, array $relations): self;

    // --------------------------------------------------------------------------

    /**
     * Deletes relations from the store
     *
     * @param Analyser        $analyser The analyser which was used
     * @param string|int|null $id       An ID to restrict the deletion to
     *
     * @return $this
     */
    public function delete(Analyser $analyser, $id): self;
}
