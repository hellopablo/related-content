<?php

namespace HelloPablo\RelatedContentEngine\Interfaces;

interface Relation
{
    /**
     * Relation constructor.
     *
     * @param string|null $type  The type of item analysed
     * @param mixed|null  $id    The ID of the analysed item
     * @param mixed|null  $value The relationship's value
     */
    public function __construct(string $type = null, $id = null, $value = null);

    // --------------------------------------------------------------------------

    /**
     * Returns the type of item that was analysed
     *
     * @return string
     */
    public function getType(): string;

    // --------------------------------------------------------------------------

    /**
     * Returns the ID of the analysed item
     *
     * @return mixed
     */
    public function getId();

    // --------------------------------------------------------------------------

    /**
     * Returns the relationship's value
     *
     * @return mixed
     */
    public function getValue();
}
