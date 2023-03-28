<html>
<title>Богатырев Дмитрий</title>
<html>
<title>Богатырев Дмитрий</title>
<?php

function debug($value)
{
    $type = gettype($value);
    echo "num_e1 = {$value} - {$type} <br>";
}
const NUM_E = 2.71828;
$num_e1 = NUM_E;
debug($num_e1);

$num_e1 = 'string';
debug($num_e1);
$num_e1 = 1;
debug($num_e1);
$num_e1 = true;
debug($num_e1);
?>



<p>
    Число e равно <?php echo NUM_E ?>
</p>