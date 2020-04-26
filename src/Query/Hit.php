<?php

namespace HelloPablo\RelatedContent\Query;

use HelloPablo\RelatedContent\Interfaces;

/**
 * Class Hit
 *
 * @package HelloPablo\RelatedContent\Query
 */
class Hit
{
    /** @var string */
    protected $analyser;

    /** @var int|string */
    protected $id;

    /** @var int */
    protected $score;

    // --------------------------------------------------------------------------

    /**
     * Hit constructor.
     *
     * @param Interfaces\Analyser $analyser The item's analyser
     * @param int|string          $id       The item's ID
     * @param int                 $score    The item's score
     */
    public function __construct(Interfaces\Analyser $analyser, $id, int $score)
    {
        $this->analyser = $analyser;
        $this->id       = $id;
        $this->score    = $score;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the item's analyser
     *
     * @return Interfaces\Analyser
     */
    public function getAnalyser(): Interfaces\Analyser
    {
        return $this->analyser;
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
