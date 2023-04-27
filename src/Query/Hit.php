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
    /** @var Interfaces\Analyser */
    protected Interfaces\Analyser $analyser;

    /** @var string|int */
    protected string|int $id;

    /** @var int */
    protected int $score;

    // --------------------------------------------------------------------------

    /**
     * Hit constructor.
     *
     * @param Interfaces\Analyser $analyser The item's analyser
     * @param string|int          $id       The item's ID
     * @param int                 $score    The item's score
     */
    public function __construct(Interfaces\Analyser $analyser, string|int $id, int $score)
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
     * @return string|int
     */
    public function getId(): string|int
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
