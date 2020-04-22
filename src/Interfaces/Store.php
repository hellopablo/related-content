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
     * @return $this
     */
    public function read(): self;

    // --------------------------------------------------------------------------

    /**
     * Writes relations to the store
     *
     * @param array $relations
     *
     * @return $this
     */
    public function write(array $relations): self;

    // --------------------------------------------------------------------------

    /**
     * Deletes relations from the store
     *
     * @param array $relations
     *
     * @return $this
     */
    public function delete(array $relations): self;
}
