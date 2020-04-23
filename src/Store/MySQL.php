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
    const DEFAULT_HOST        = '127.0.0.1';
    const DEFAULT_USER        = '';
    const DEFAULT_PASS        = '';
    const DEFAULT_DATABASE    = '';
    const DEFAULT_TABLE       = 'related_content_data';
    const DEFAULT_PORT        = '3306';
    const DEFAULT_CHARSET     = 'utf8mb4';
    const DEFAULT_PDO_OPTIONS = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // --------------------------------------------------------------------------

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
        $this->host        = $config['host'] ?? static::DEFAULT_HOST;
        $this->user        = $config['user'] ?? static::DEFAULT_USER;
        $this->pass        = $config['pass'] ?? static::DEFAULT_PASS;
        $this->database    = $config['database'] ?? static::DEFAULT_DATABASE;
        $this->table       = $config['table'] ?? static::DEFAULT_TABLE;
        $this->port        = $config['port'] ?? static::DEFAULT_PORT;
        $this->charset     = $config['charset'] ?? static::DEFAULT_CHARSET;
        $this->pdo_options = $config['pdo_options'] ?? static::DEFAULT_PDO_OPTIONS;

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

        $this->pdo = new PDO($dsn, $this->user, $this->pass, $this->pdo_options);


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
        return null !== $this->getConnection();
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
