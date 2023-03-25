<?php

// 6
$a = rand(-20, 20);
$c = rand(-20, 20);
$d = rand(-20, 20);

try {
    $result = (2 * $c - 42 * $d) / ($c + $a - 1);
} catch (DivisionByZeroError $e) {
    die("Ошибка: деление на ноль");
}

echo "(2 * $c - 42 * $d) / ($c + $a - 1) = $result";

echo "<br>";

// 7
$a = rand(-20, 20);
$c = rand(-20, 20);
$b = rand(-20, 20);
$d = rand(-20, 20);

try {
    $result = (42 * $c - ($d / 2) + 1) / (pow($a, 2) - $b - 5);
} catch (DivisionByZeroError $e) {
    die("Ошибка: деление на ноль");
}

echo "42 * $c - ($d / 2) + 1) / ($a^2 - $b - 5) = $result";

echo "<br>";

// 8
$a = rand(-20, 20);
$c = rand(-20, 20);
$b = rand(-20, 20);
$d = rand(-20, 20);

try {
    $otvet = ($b * (2 * $c) + $d - 52) / (($a / 3) + 1);
} catch (DivisionByZeroError $e) {
    die("Ошибка: деление на ноль");
}

echo "($b * (2 * $c) + $d - 52) / (($a / 3) + 1) = $otvet<br>";

// 9
$a = rand(-20, 20);
$c = rand(-20, 20);
$b = rand(-20, 20);
$d = rand(-20, 20);

try {
    $otvet = ((25 / $c) - $d + 2) / ($d + pow($a, 2) - 1);
} catch (DivisionByZeroError $e) {
    die("Ошибка: деление на ноль");
}

echo "((25 / $c) - $d + 2) / ($d + $a^2 - 1) = $otvet<br>";