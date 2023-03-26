<?php

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod !== 'POST') {
    http_response_code(400);
    die("Request method must be POST");
}

if (!isset($_POST['number-1']) || !isset($_POST['number-2'])) {
    http_response_code(400);
    die("Field number-1 and number-2 is required.");
}

$numberOne = $_POST['number-1'];
$numberTwo = $_POST['number-2'];

if (!is_numeric($numberOne) || !is_numeric($numberTwo)) {
    http_response_code(400);
    die("Field number-1 and number-2 must be number.");
}

$numberOne = (float) $numberOne;
$numberTwo = (float) $numberTwo;

echo "Ответ: ";

if ($numberOne === $numberTwo) {
    echo "Числа равны";
} elseif ($numberOne > $numberTwo) {
    echo $numberOne;
} else {
    echo $numberTwo;
}

if (key_exists('HTTP_REFERER', $_SERVER)) {
    echo "<br><a href='" . $_SERVER['HTTP_REFERER'] . "'>Вернуться</a>";
}
