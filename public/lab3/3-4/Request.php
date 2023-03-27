<?php

namespace lab3s34;

class Request
{
    /** @var array */
    private $params;

    /** @var string */
    private $method;

    /**
     * @param string $method
     * @param array $params
     */
    private function __construct(string $method, array $params)
    {
        $this->method = $method;
        $this->params = $params;
    }


    public static function createFromGlobals(): Request
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $params = $_GET;
        } elseif ($method === 'POST') {
            $params = $_POST;

            // PUT, DELETE...
        } else {
            $params = [];
        }

        return new self(
            $method,
            $params
        );
    }

    /**
     * @param string $name
     * @return float|null
     */
    public function getNumber(string $name): ?float
    {
        if (key_exists($name, $this->params)) {
            if (is_numeric($this->params[$name]))
                return (float) $this->params[$name];
        }

        return null;
    }

    public function getString(string $name): ?string
    {
        if (key_exists($name, $this->params)) {
            return (string) $this->params[$name];
        }

        return null;
    }

    public function has(string $name): bool
    {
        return key_exists($name, $this->params);
    }

    public function isPostMethod(): bool
    {
        return $this->method === 'POST';
    }
}