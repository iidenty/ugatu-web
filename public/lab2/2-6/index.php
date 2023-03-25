<?php

include_once "lib.php";

$n = rand(4, 10);

renderTaskConditions();

$matrix = createMatrix($n, $n);

renderMatrix($matrix);

handleMatrix($matrix);