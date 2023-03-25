<?php

const MIN_RAND_ARR_VALUE = -10;
const MAX_RAND_ARR_VALUE = 10;
const DEFAULT_TABLE_ATTR = 'cellspacing="1" border="1" cellpadding="2"';

function renderTaskConditions(): void {
    echo "Дана квадратная матрица порядка N. Для каждого столбца матрицы найти наименьший элемент. 
    Вычислить и напечатать произведение найденных наименьших элементов. ";
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

    $htmlTableHead = "<table " . DEFAULT_TABLE_ATTR . ">";
    $htmlTableEnd = "</table>";
    $htmlTableContent = "";

    foreach ($matrix as $row) {
        if (!is_array($row))
            throw new InvalidArgumentException('Row must be array.');

        if (empty($row))
            throw new InvalidArgumentException('Row must not be empty.');

        $htmlTableContent .= "<tr>";

        foreach ($row as $value) {
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

    $minValues = [];
    $resultValue = 1;
    foreach ($transposedMatrix as $row) {
        $min = min($row);
        $minValues[] = $min;
        $resultValue *= $min;
    }

    echo implode(' * ', $minValues) . ' = ' . $resultValue;
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