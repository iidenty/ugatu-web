<?php

/**
 * @param $u
 * @param $t
 * @return float|int
 */
function f($u, $t) {
    if ($u >= 0 && $t >= 0) {
        return ($u / $t) - pow($t,2) * $u;
    } elseif ($u < 0 && $t >= 0) {
        return $u + (pow($t,2) / $u);
    } elseif ($u >= 0 && $t < 0) {
        return $u - $t;
    } elseif ($u < 0 && $t < 0) {
        return ($t + 3 * $u) / ($u * $t);
    }
}

$a = rand(-30, 30);
$b = rand(-30, 30);

$z = f($a + (1 / $b), (pow($b,8)) / (pow($a,6))) + f(pow($a,3 / 4) + pow($b,5 / 6), $b - $a);

echo $z;

