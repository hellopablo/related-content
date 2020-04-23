<?php

namespace HelloPablo\RelatedContentEngine\Store;

use Exception;
use HelloPablo\RelatedContentEngine\Interfaces;
use HelloPablo\RelatedContentEngine\Query;
use HelloPablo\RelatedContentEngine\Relation;
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
     *
     * @throws Exception
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

        if (!extension_loaded('pdo')) {
            throw new Exception('PDO extension not installed');
        }
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

        $this->initTable();

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Creates the data table if it does not exist
     */
    protected function initTable()
    {
        $this->pdo->query('
            CREATE TABLE IF NOT EXISTS `' . $this->table . '` (
                `hash` varchar(300) CHARACTER SET utf8mb4 DEFAULT NULL,
                `entity` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
                `id` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
                `type` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
                `value` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL
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
     * Reads data from the store
     *
     * @param string           $entity The entity type the ID belongs to
     * @param string|int|array $id     Filter by ID(s)
     *
     * @return Interfaces\Relation[]
     */
    public function read(string $entity, $id): array
    {
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
     * @param string     $entity    The entity type the ID belongs to
     * @param string|int $id        The ID the relations belong to
     * @param array      $relations Array of the relations
     *
     * @return $this
     */
    public function write(string $entity, $id, array $relations): Interfaces\Store
    {
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
     */
    public function delete(string $entity, $id): Interfaces\Store
    {
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
     *
     * @return Query\Hit[]
     */
    public function query(
        array $sourceRelations,
        string $sourceEntity,
        $sourceId,
        array $restrict = [],
        int $limit = null
    ): array {

        if (empty($sourceRelations)) {
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
            !empty($limit) ? 'LIMIT ' . $limit : ''
        );

        $statement = $this->pdo
            ->query($sql);

        return array_map(
            function (\stdClass $hit) {
                return new Query\Hit(
                    $hit->entity,
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
     * @param string $entity The item'sentity string
     * @param mixed  $id     The item's ID
     *
     * @return string
     */
    protected function generateHash(string $entity, $id): string
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
