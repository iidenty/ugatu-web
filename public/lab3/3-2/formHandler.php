<?php

class InvalidActionException extends Exception {}

class Action
{
    private const ACTION_SUM = 'ACTION_SUM';
    private const ACTION_SUBTRACT = 'ACTION_SUM';
    private const ACTION_MULTIPLY = 'ACTION_MULTIPLY';
    private const ACTION_DIVIDE = 'ACTION_DIVIDE';

    private const VALUES = [
        self::ACTION_SUM,
        self::ACTION_SUBTRACT,
        self::ACTION_MULTIPLY,
        self::ACTION_DIVIDE,
    ];

    /** @var string */
    private $value;

    /**
     * @param string $value
     * @throws InvalidActionException
     */
    public function __construct(string $value)
    {
        if (!in_array($value, self::VALUES))
            throw new InvalidActionException('Invalid action type.');

        $this->value = $value;
    }

    /**
     * @param float|integer $valueOne
     * @param float|integer $valueTwo
     * @return float|integer
     * @throws DivisionByZeroError
     */
    public function handle($valueOne, $valueTwo)
    {
        if ($this->value === self::ACTION_SUM) {
            return $valueOne + $valueTwo;
        } elseif ($this->value === self::ACTION_SUBTRACT) {
            return $valueOne - $valueTwo;
        } elseif ($this->value === self::ACTION_MULTIPLY) {
            return $valueTwo * $valueTwo;
        } elseif ($this->value === self::ACTION_DIVIDE) {
            return $valueOne / $valueTwo;
        }
    }
}

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

$request = Request::createFromGlobals();

if (!$request->isPostMethod()) {
    http_response_code(400);
    die("Request method must be POST");
}

// VALIDATE EXISTING
$fields = [
    'number-1',
    'number-2',
    'action'
];

$errors = [];

foreach ($fields as $field) {
    if (!$request->has($field))
        $errors[] = $field . ' is required.';
}

if (count($errors) > 0) {
    http_response_code(400);
    die('Ошибка запроса: <br>' . implode(', ', $errors));
}

// VALIDATE TYPE
if (($numberOne = $request->getNumber('number-1')) === null) {
    http_response_code(400);
    die('Ошибка запроса: number-1 must be a number');
}

if (($numberTwo = $request->getNumber('number-2')) === null) {
    http_response_code(400);
    die('Ошибка запроса: number-2 must be a number.');
}

try {
    $action = new Action($request->getString('action'));
} catch (InvalidActionException $e) {
    http_response_code(400);
    die("Ошибка запроса: action должен быть одним из [ACTION_SUM, ACTION_SUBTRACT, ACTION_MULTIPLY, ACTION_DIVIDE]");
}

// Handle action
try {
    $result = $action->handle($numberOne, $numberTwo);

    echo "Ответ: " . $result;

    if (key_exists('HTTP_REFERER', $_SERVER)) {
        echo "<br><a href='" . $_SERVER['HTTP_REFERER'] . "'>Вернуться</a>";
    }
} catch (DivisionByZeroError $e) {
    http_response_code(400);
    die("Ошибка: попытка поделить на 0");
}
