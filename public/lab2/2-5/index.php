<?php

/**
 * @param $u
 * @param $t
 * @return float|int
 */
function f($u, $t) {
    if ($u >= 0 && $t >= 0) {
        return $u + $t;
    } elseif ($u < 0 && $t >= 0) {
        return pow($u, 2) + $t;
    } elseif ($u >= 0 && $t < 0) {
        return $u - 2 * $t;
    } elseif ($u < 0 && $t < 0) {
        return ($t + 3 * $u) / ($u * $t);
    }
}

$a = rand(-30, 30);
$b = rand(-30, 30);

$z = f($a, pow($b, 8) - pow($a, 7)) + f(pow($a, 10) - pow($b, 11), $b);

echo $z;

