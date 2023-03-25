<?php
    $counter = 1;
?>

<style>
    .red {
        color: red;
    }
</style>

<table cellspacing="1" border="1" cellpadding="2">
    <?php for ($i = 0; $i < 10; $i++): ?>
        <tr>
            <?php for ($c = 0; $c < 10; $c++): ?>
                <td class="<?php if ($counter % 2 == 0) echo 'red'?>"><?php echo $counter; $counter++?></td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>
