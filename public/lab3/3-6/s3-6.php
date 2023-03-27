<?php

namespace lab3s36;


require_once "Request.php";
require_once "BadRequestException.php";

$request = \lab3s36\Request::createFromGlobals();

if (!$request->isPostMethod())
    throw new \lab3s36\BadRequestException('Only post methods.');

$content = $request->getString('content');

if ($content === null)
    throw new \lab3s36\BadRequestException('Content is required field.');

$pattern = '~(?<vowels>[аеёиоуыэюя])|(?<conson>[бвгджзйклмнпрстфхцчшщъь])~iu';

preg_match_all($pattern, $content, $m);

$vowels = count(array_filter($m['vowels']));

echo "Количество гласных букв: $vowels";