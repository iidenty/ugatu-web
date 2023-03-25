<?php

/**
 * Найти все целые числа из интервала от N до М, которые можно представить в виде суммы
 * кубов трех натуральных чисел. N и М – случайные числа.
 */

$N = rand(1,2);
$M = rand(110,220);

//$i = $N;
$end = $M;

$result = [];

for ($i = $N; $i < $M; $i++) {
    for ($n1 = 1; $n1 < $i; $n1++) {
        for ($n2 = 1; $n2 < $i; $n2++) {
            for ($n3 = 1; $n3 < $i; $n3++) {
                if (pow($n1, 3) + pow($n2, 3) + pow($n3, 3) === $i) {
                    $result[$i] = [$n1, $n2, $n3];
                    // TODO: return?
                }
            }
        }
    }
}

foreach ($result as $key => $terms) {
    echo "$key<br>";
}