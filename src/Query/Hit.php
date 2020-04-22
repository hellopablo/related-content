<?php

namespace HelloPablo\RelatedContentEngine\Query;

/**
 * Class Hit
 *
 * @package HelloPablo\RelatedContentEngine\Query
 */
class Hit
{
    /** @var string */
    protected $type;

    /** @var int|string */
    protected $id;

    /** @var int */
    protected $score;

    // --------------------------------------------------------------------------

    /**
     * Hit constructor.
     *
     * @param string     $type  The item's type
     * @param int|string $id    The item's ID
     * @param int        $score The item's score
     */
    public function __construct(string $type, $id, int $score)
    {
        $this->type  = $type;
        $this->id    = $id;
        $this->score = $score;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the item's type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the item's ID
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the item's score
     *
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }
}
