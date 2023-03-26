<?php

class InvalidActionException extends Exception {}

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

function isPrime(int $number): bool {
    for ($i = 2; $i < $number; $i++) {
        if ($number % $i === 0)
            return false;
    }

    return true;
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Прытков Данил ПИ228-БЗУ</title>
</head>
<body>

<form action="s3-3.php" method="post">
    <input type="text" name="number" placeholder="Число">
    <select name="operation">
        <option value="OPERATION_1">четные делители</option>
        <option value="OPERATION_2">нечетные делители</option>
        <option value="OPERATION_3">простые делители</option>
        <option value="OPERATION_4">составные делители</option>
        <option value="OPERATION_5">все делители</option>
    </select>
    <button type="submit">Отправить</button>
</form>

<?php

if (!$request->isPostMethod())
    return;

if (!$request->has('operation')) {
    http_response_code(400);
    echo 'Ошибка: operation is required filed.';
    return;
}

// TODO: make validation
$number = $request->getNumber('number');

$dividers = [];
for ($i = 2; $i < $number; $i++) {
    if ($number % $i === 0)
        $dividers[] = $i;
}

$operation = $request->getString('operation');

$resultList = [];

// TODO: make fabric and user friendly const's
if ($operation === 'OPERATION_1') {
    foreach ($dividers as $divider) {
        if ($divider % 2 === 0)
            $resultList[] = $divider;
    }
} elseif ($operation === 'OPERATION_2') {
    foreach ($dividers as $divider) {
        if ($divider % 2 !== 0)
            $resultList[] = $divider;
    }
} elseif ($operation === 'OPERATION_3') {
    foreach ($dividers as $divider) {
        // TODO: it is slow
        if (isPrime($divider))
            $resultList[] = $divider;
    }
} elseif ($operation === 'OPERATION_4') {
    foreach ($dividers as $divider) {
        // TODO: it is slow
        if (!isPrime($divider))
            $resultList[] = $divider;
    }
} elseif ($operation === 'OPERATION_5') {
    $resultList = $dividers;
} else {
    http_response_code(400);
    echo "Ошибка: operation contain not valid choice.";
    return;
}

echo "<br>Ответ: " . implode(', ', $resultList);


?>


</body>
</html>