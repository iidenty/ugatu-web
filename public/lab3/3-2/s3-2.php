<?php

class InvalidActionException extends Exception {}

class Action
{
    private const ACTION_SUM = 'ACTION_SUM';
    private const ACTION_SUBTRACT = 'ACTION_SUBTRACT';
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

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Прытков Д.О. ПИ-228 БЗУ</title>
</head>
<body>

<style>
    .input-group {
        margin-bottom: 1rem;
    }
</style>

<form action="s3-2.php" method="post">
    <h3>Калькулятор</h3>
    <div class="input-group">
        <input name="number-1" type="text" placeholder="0" value="<?php echo $request->getString('number-1') ?>">
        <input name="number-2" type="text" placeholder="0" value="<?php echo $request->getString('number-2') ?>">
    </div>
    <div class="input-group">
        действие:
        <select name="action" >
            <option value="ACTION_SUM" <?php if ($request->getString("action") === "ACTION_SUM") echo "selected";?>>сложить</option>
            <option value="ACTION_SUBTRACT" <?php if ($request->getString("action") === "ACTION_SUBTRACT") echo "selected";?>>вычесть</option>
            <option value="ACTION_MULTIPLY" <?php if ($request->getString("action") === "ACTION_MULTIPLY") echo "selected";?>>умножить</option>
            <option value="ACTION_DIVIDE" <?php if ($request->getString("action") === "ACTION_DIVIDE") echo "selected";?>>разделить</option>
        </select>
    </div>
    <button type="submit" style="margin-bottom: 1rem">Отправить</button>
</form>

<?php

if (!$request->isPostMethod()) {
    return;
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
    echo 'Ошибка запроса: <br>' . implode(', ', $errors);
    return;
}

// VALIDATE TYPE
if (($numberOne = $request->getNumber('number-1')) === null) {
    http_response_code(400);
    echo 'Ошибка запроса: number-1 must be a number';
    return;
}

if (($numberTwo = $request->getNumber('number-2')) === null) {
    http_response_code(400);
    echo 'Ошибка запроса: number-2 must be a number.';
    return;
}

try {
    $action = new Action($request->getString('action'));
} catch (InvalidActionException $e) {
    http_response_code(400);
    echo "Ошибка запроса: action должен быть одним из [ACTION_SUM, ACTION_SUBTRACT, ACTION_MULTIPLY, ACTION_DIVIDE]";
    return;
}

// Handle action
try {
    $result = $action->handle($numberOne, $numberTwo);

    echo "Ответ: " . $result;
} catch (DivisionByZeroError $e) {
    http_response_code(400);
    echo "Ошибка: попытка поделить на 0";
    return;
}

?>

</body>
</html>