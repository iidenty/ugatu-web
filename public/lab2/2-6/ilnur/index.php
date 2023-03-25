<?php

include_once "lib.php";

$k = rand(4, 10);

renderTaskConditions();

$matrix = createMatrix($k, $k);

renderMatrix($matrix);

handleMatrix($matrix);