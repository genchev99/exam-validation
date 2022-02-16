<?php
/**
 * Escapes input so NONO to SQL Injections
 * @param $input - the raw string
 * @return string - the defanged string
 */
function test_input($input): string {
    $input = trim($input);
    $input = htmlspecialchars($input);
    return stripslashes($input);
}

function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";") {
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    // open the "output" stream
    // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
    $f = fopen('php://output', 'w');

    foreach ($array as $line) {
        fputcsv($f, $line, $delimiter);
    }
}

function first_index_of_arr_of_objects($arr, $key, $value): int {
    $index = 0;
    foreach ($arr as $obj) {
        if (isset($obj[$key]) && $obj[$key] == $value) {
            return $index;
        }
        $index += 1;
    }

    return -1;
}
