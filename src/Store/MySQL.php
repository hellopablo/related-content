<?php

namespace HelloPablo\RelatedContentEngine\Store;

use HelloPablo\RelatedContentEngine\Interfaces\Store;
use PDO;

class MySQL implements Store
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
    public function __construct(array $config)
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
    public function connect(): Store
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
    public function disconnect(): Store
    {
        $this->pdo = null;
        return $this;
    }

    // ------------------// --------------------------------------------------------------------------------------------------------------------------------

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
     * Reads data from the store
     *
     * @return $this
     */
    public function read(): Store
    {
        // TODO: Implement read() method.
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Writes relations to the store
     *
     * @param array $relations
     *
     * @return $this
     */
    public function write(array $relations): Store
    {
        // TODO: Implement write() method.
        //  @todo (Pablo - 2020-04-22) - https://gist.github.com/gskema/7a7c0eec2a7b97b4b03a
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Deletes relations from the store
     *
     * @param array $relations
     *
     * @return $this
     */
    public function delete(array $relations): Store
    {
        // TODO: Implement delete() method.
        return $this;
    }
}
