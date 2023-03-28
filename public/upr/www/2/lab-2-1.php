<?php
function check($a, $b)
{
    if ($a) {
        echo '$a=' . "$a - истина<br>";
    } else {
        echo '$a=' . "$a - ложь<br>";
    }
    if ($b) {
        echo '$b=' . "$b - истина<br>";
    } else {
        echo '$b=' . "$b - ложь<br>";
    }
}
$a = 1;
$b = false;
check($a, $b);
$а = 0;
$b = "0";
check($a, $b);
$а = 10;
$b = "true";
check($a, $b);
$а = false;
$b = "false";
check($a, $b);
$а = -1;
$b = "";
check($a, $b);
?>