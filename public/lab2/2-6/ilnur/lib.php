<?php

const MIN_RAND_ARR_VALUE = -10;
const MAX_RAND_ARR_VALUE = 10;
const DEFAULT_TABLE_ATTR = 'cellspacing="1" border="1" cellpadding="2"';

function renderTaskConditions(): void {
    echo "В матрице К(n,n) присвоить каждому диагональному элементу разность между суммами
элементов соответствующих строки и столбца";
}

/**
 * Возвращает двумерный массив размерностью $columnCount X $rowCount
 * со случайными значениями от MIN_RAND_ARR_VALUE до MAX_RAND_ARR_VALUE
 * @param int $columnCount
 * @param int $rowCount
 * @return array[]
 */
function createMatrix(int $columnCount, int $rowCount): array {
    if ($columnCount < 1 or $rowCount < 1)
        throw new InvalidArgumentException('Column count and row count must be greater than 0.');

    $matrix = [];

    for ($i = 0; $i < $columnCount; $i++) {
        for ($c = 0; $c < $rowCount; $c++) {
            $matrix[$i][$c] = rand(MIN_RAND_ARR_VALUE, MAX_RAND_ARR_VALUE);
        }
    }

    return $matrix;
}

/**
 * @param array[] $matrix
 * @return void
 */
function renderMatrix(array $matrix): void {
    if (empty($matrix))
        return;

    $rowCount = count($matrix);

    $htmlTableHead = "<table " . DEFAULT_TABLE_ATTR . ">";
    $htmlTableEnd = "</table>";
    $htmlTableContent = "";

    foreach ($matrix as $keyRow => $row) {
        if (!is_array($row))
            throw new InvalidArgumentException('Row must be array.');

        if (empty($row))
            throw new InvalidArgumentException('Row must not be empty.');

        $htmlTableContent .= "<tr>";

        foreach ($row as $keyColumn => $value) {
            if ($keyColumn === $keyRow or $rowCount - $keyRow - 1 === $keyColumn)
                $htmlTableContent .= "<td style='color: red'>";
            else
                $htmlTableContent .= "<td>";

            $htmlTableContent .= $value;
            $htmlTableContent .= "</td>";
        }

        $htmlTableContent .= "</tr>";
    }

    echo $htmlTableHead . $htmlTableContent . $htmlTableEnd;
}

/**
 * @param array[] $matrix
 * @return void
 */
function handleMatrix(array $matrix): void {
    if (empty($matrix))
        throw new InvalidArgumentException('Matrix must not be empty');

    $transposedMatrix = getTransposedMatrix($matrix);

    $resultMatrix = $matrix;

    $rowCount = count($matrix);

    for ($i = 0; $i < count($matrix); $i++) {
        $sumMatrix = array_sum($matrix[$i]);
        $sumTransMatrix = array_sum($transposedMatrix[$i]);
        $sumSideTransMatrix = array_sum($transposedMatrix[$rowCount - $i - 1]);

        $resultMatrix[$i][$i] = $sumMatrix - $sumTransMatrix;
        $resultMatrix[$i][$rowCount - $i - 1] = $sumMatrix - $sumSideTransMatrix;
    }

    echo "<br>Вывод: ";
    renderMatrix($resultMatrix);
}

function getTransposedMatrix(array $matrix): array {
    $transposedMatrix = [];

    for ($i = 0; $i < count($matrix); $i++) {
        for ($c = 0; $c < count($matrix[$i]); $c++) {
            $transposedMatrix[$c][$i] = $matrix[$i][$c];
        }
    }

    return $transposedMatrix;
}