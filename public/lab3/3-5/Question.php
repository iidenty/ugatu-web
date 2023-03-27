<?php

namespace lab3s35;

class Question
{
    /** @var string */
    private $id;

    /** @var string */
    private $text;

    /** @var int */
    private $scopeFalse;

    /** @var int */
    private $scopeTrue;

    /**
     * @param string $id
     * @param string $text
     * @param int $scopeFalse
     * @param int $scopeTrue
     */
    public function __construct(
        string $id,
        string $text,
        int $scopeFalse,
        int $scopeTrue
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->scopeFalse = $scopeFalse;
        $this->scopeTrue = $scopeTrue;
    }

    public function answer(bool $choice): int
    {
        if ($choice)
            return $this->scopeTrue;

        return $this->scopeFalse;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}