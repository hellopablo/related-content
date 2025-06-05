<?php

namespace HelloPablo\RelatedContent\Store;

use Exception;
use HelloPablo\RelatedContent\Exception\MissingExtension;
use HelloPablo\RelatedContent\Exception\NotConnectedException;
use HelloPablo\RelatedContent\Interfaces;
use HelloPablo\RelatedContent\Query;
use HelloPablo\RelatedContent\Relation;
use PDO;
use stdClass;

/**
 * Class MySQL
 *
 * @package HelloPablo\RelatedContent\Store
 */
class MySQL implements Interfaces\Store
{
    public const DEFAULT_HOST        = '127.0.0.1';
    public const DEFAULT_USER        = '';
    public const DEFAULT_PASS        = '';
    public const DEFAULT_DATABASE    = '';
    public const DEFAULT_TABLE       = 'related_content_data';
    public const DEFAULT_PORT        = '3306';
    public const DEFAULT_CHARSET     = 'utf8mb4';
    public const DEFAULT_PDO_OPTIONS = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // --------------------------------------------------------------------------

    /** @var string */
    protected string $host;

    /** @var string */
    protected string $user;

    /** @var string */
    protected string $pass;

    /** @var string */
    protected string $database;

    /** @var string */
    protected string $table;

    /** @var string */
    protected string $port;

    /** @var string */
    protected string $charset;

    /** @var PDO|null */
    protected ?PDO $pdo;

    /** @var mixed[] */
    protected array $pdoOptions;

    // --------------------------------------------------------------------------

    /**
     * MySQL constructor.
     *
     * @param mixed[] $config Config array as required by the driver
     *
     * @throws MissingExtension
     */
    public function __construct(array $config = [])
    {
        $this->host       = $config['host'] ?? static::DEFAULT_HOST;
        $this->user       = $config['user'] ?? static::DEFAULT_USER;
        $this->pass       = $config['pass'] ?? static::DEFAULT_PASS;
        $this->database   = $config['database'] ?? static::DEFAULT_DATABASE;
        $this->table      = $config['table'] ?? static::DEFAULT_TABLE;
        $this->port       = $config['port'] ?? static::DEFAULT_PORT;
        $this->charset    = $config['charset'] ?? static::DEFAULT_CHARSET;
        $this->pdoOptions = $config['pdo_options'] ?? static::DEFAULT_PDO_OPTIONS;

        if (!extension_loaded('pdo')) {
            throw new MissingExtension('PDO extension not installed');
        }
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
        try {

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s;port=%s',
                $this->host,
                $this->database,
                $this->charset,
                $this->port
            );

            $this->pdo = new PDO($dsn, $this->user, $this->pass, $this->pdoOptions);

            $this->initTable();

        } catch (Exception $e) {
            throw new NotConnectedException('Failed to connect to MYSQL: ' . $e->getMessage(), $e->getCode(), $e);
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Creates the data table if it does not exist
     *
     * @throws NotConnectedException
     */
    protected function initTable(): void
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

        $this->pdo
            ->query('
                CREATE TABLE IF NOT EXISTS `' . $this->table . '` (
                    `hash` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
                    `entity` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
                    `id` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
                    `type` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
                    `value` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
                    KEY `entity` (`entity`,`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ');
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
     * @return PDO|null
     */
    public function getConnection(): ?PDO
    {
        return $this->pdo;
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

        $statement = $this->pdo
            ->query(
                sprintf(
                    'SELECT * FROM %s',
                    $this->table
                )
            );

        return $statement->fetchAll(PDO::FETCH_OBJ);
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

        $this->pdo
            ->query(
                sprintf(
                    'TRUNCATE %s',
                    $this->table
                )
            );

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
    public function read(string $entity, string|int $id): array
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

        $statement = $this->pdo
            ->prepare(
                sprintf(
                    'SELECT * FROM %s WHERE entity = :entity AND id = :id',
                    $this->table
                )
            );

        $statement
            ->execute([
                'entity' => $entity,
                'id'     => $id,
            ]);

        $results = [];
        foreach ($statement->fetchAll(PDO::FETCH_OBJ) as $row) {
            $results[] = new Relation\Node(
                $row->type,
                $row->value
            );
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
    public function write(string $entity, string|int $id, array $relations): Interfaces\Store
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

        $statement = $this->pdo
            ->prepare(
                sprintf(
                    'INSERT INTO %s (hash, entity, id, type, value) VALUES (:hash, :entity, :id, :type, :value)',
                    $this->table
                )
            );

        foreach ($relations as $relation) {
            $statement
                ->execute([
                    'hash'   => $this->generateHash($entity, $id),
                    'entity' => $entity,
                    'id'     => $id,
                    'type'   => $relation->getType(),
                    'value'  => $relation->getValue(),
                ]);
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Deletes relations from the store
     *
     * @param string     $entity The entity type the ID belongs to
     * @param string|int $id     The ID of the item to delete relations for
     *
     * @return $this
     * @throws NotConnectedException
     */
    public function delete(string $entity, string|int $id): Interfaces\Store
    {
        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        }

        $statement = $this->pdo
            ->prepare(
                sprintf(
                    'DELETE FROM %s WHERE entity = :entity AND id = :id',
                    $this->table
                )
            );

        $statement
            ->execute([
                'entity' => $entity,
                'id'     => $id,
            ]);

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
        string|int $sourceId,
        array $restrict = [],
        ?int $limit = null,
        int $offset = 0
    ): array {

        if (!$this->isConnected()) {
            throw new NotConnectedException('Store not connected');
        } elseif (empty($sourceRelations)) {
            return [];
        }

        $where = [];

        //  Exclude the source item
        $where[] = sprintf(
            'hash != "%s"',
            $this->generateHash($sourceEntity, $sourceId)
        );

        //  Include matching items
        $overlaps = array_map(
            function ($relation) {
                return sprintf(
                    '(type = "%s" AND value = "%s")',
                    $relation->getType(),
                    $relation->getValue()
                );
            },
            $sourceRelations
        );

        $where[] = '(' . implode(' OR ', $overlaps) . ')';

        //  Restrict to entities if specified
        if (!empty($restrict)) {
            $where[] = sprintf(
                'entity IN ("%s")',
                implode(
                    '", "',
                    array_map(
                        function ($restrict) {
                            return str_replace('\\', '\\\\', $restrict);
                        },
                        $restrict
                    )
                )
            );
        }

        //  Compile the query
        $sql = sprintf(
            'SELECT entity, id, COUNT(*) score FROM %s WHERE %s GROUP BY entity,id ORDER BY score DESC %s',
            $this->table,
            implode(' AND ', $where),
            !empty($limit) ? 'LIMIT ' . $offset . ', ' . $limit : ''
        );

        $statement = $this->pdo
            ->query($sql);

        return array_map(
            function (stdClass $hit) {
                return new Query\Hit(
                    new $hit->entity(),
                    $hit->id,
                    $hit->score
                );
            },
            $statement->fetchAll(PDO::FETCH_OBJ)
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Generates the item's hash
     *
     * @param string     $entity The item'sentity string
     * @param string|int $id     The item's ID
     *
     * @return string
     */
    public function generateHash(string $entity, string|int $id): string
    {
        return md5(
            sprintf(
                '%s::%s',
                $entity,
                $id
            )
        );
    }
}
