<?php

namespace HelloPablo\RelatedContentEngine\Store;

use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Query;
use PDO;

/**
 * Class MySQL
 *
 * @package HelloPablo\RelatedContentEngine\Store
 */
class MySQL implements Interfaces\Store
{
    /** @var string */
    protected $host;

    /** @var string */
    protected $user;

    /** @var string */
    protected $pass;

    /** @var string */
    protected $database;

    /** @var string */
    protected $table;

    /** @var string */
    protected $port;

    /** @var string */
    protected $charset;

    /** @var PDO */
    protected $pdo;

    /** @var array */
    protected $pdo_options;

    // --------------------------------------------------------------------------

    /**
     * MySQL constructor.
     *
     * @param array $config Config array as required by the driver
     */
    public function __construct(array $config = [])
    {
        $this->host        = $config['host'] ?? '127.0.0.1';
        $this->user        = $config['user'] ?? '';
        $this->pass        = $config['pass'] ?? '';
        $this->database    = $config['database'] ?? '';
        $this->table       = $config['table'] ?? '';
        $this->port        = $config['port'] ?? '3306';
        $this->charset     = $config['charset'] ?? 'utf8mb4';
        $this->pdo_options = $config['pdo_options'] ?? [];

        //  @todo (Pablo - 2020-04-22) - Validate PDO is enabled
    }

    // --------------------------------------------------------------------------

    /**
     * Opens a connection to the store
     *
     * @return $this
     */
    public function connect(): Interfaces\Store
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $this->host,
            $this->database,
            $this->charset
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);

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
        return null === $this->getConnection();
    }

    // --------------------------------------------------------------------------

    /**
     * Disconnects the connection
     *
     * @return $this
     */
    public function disconnect(): Interfaces\Store
    {
        $this->pdo = null;
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
        return $this->pdo;
    }

    // --------------------------------------------------------------------------

    /**
     * Dumps the entire contents of the data store
     *
     * @return array
     */
    public function dump(): array
    {
        // TODO: Implement dump() method.
        return [];
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
        // TODO: Implement read() method.
        return [];
    }

    // --------------------------------------------------------------------------

    /**
     * Writes relations to the store
     *
     * @param Interfaces\Analyser $analyser  The analyser which was used
     * @param string|int          $id        The ID the relations belong to
     * @param array               $relations Array of the relations
     *
     * @return $this
     */
    public function write(Interfaces\Analyser $analyser, $id, array $relations): Interfaces\Store
    {
        // TODO: Implement write() method.
        //  @todo (Pablo - 2020-04-22) - https://gist.github.com/gskema/7a7c0eec2a7b97b4b03a
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Deletes relations from the store
     *
     * @param Interfaces\Analyser $analyser The analyser which was used
     * @param string|int|null     $id       An ID to restrict the deletion to
     *
     * @return $this
     */
    public function delete(Interfaces\Analyser $analyser, $id): Interfaces\Store
    {
        // TODO: Implement delete() method.
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
        //  @todo (Pablo - 2020-04-22) - Implement this
        return [];
    }
}
