<?php

namespace lab3s36iln;


require_once "Request.php";
require_once "BadRequestException.php";

$request = \lab3s36iln\Request::createFromGlobals();

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Басыров ИЗ ПИ228-БЗУ</title>
</head>
<body>
<?php

try {
    if (!$request->isPostMethod())
        throw new \lab3s36iln\BadRequestException('Only post methods.');

    $content = $request->getString('content');

    if ($content === null)
        throw new \lab3s36iln\BadRequestException('Content is required field.');
    $resultSymbols = [];

    $strLen = strlen($content);
    for ($i = 0; $i < $strLen; $i++) {
        $symbol = mb_substr($content, $i, 1, 'UTF-8');

        if (!in_array($symbol, $resultSymbols)) {
            $resultSymbols[] = $symbol;
        }
    }

    echo implode($resultSymbols);
} catch (BadRequestException $e) {
    echo $e->getMessage();
}

?>
</body>
</html>
