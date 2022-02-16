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

function object_to_json_download($object, $filename = "export.json") {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    // open the "output" stream
    // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
    $f = fopen('php://output', 'w');

    fwrite($f, json_encode($object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function object_to_html_download($object, $filename = "export.html") {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    // open the "output" stream
    // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
    $f = fopen('php://output', 'w');

    fwrite($f, "
        <html><head><meta charset='UTF-8'><title>Въпроси</title><style>
            table { border-collapse: collapse; }
            th, td { border: 1px solid #ccc; padding: 8px; }
        </style></head><body>");
    fwrite($f, json_to_table(json_encode($object)));
    fwrite($f, "</body></html>");
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

function _json_to_table_recursive_helper($arr): string {
    $str = "<table><tbody>";
    foreach ($arr as $key => $val) {
        $str .= "<tr>";
        $str .= "<td>$key</td>";
        $str .= "<td>";
        if (is_array($val)) {
            if (!empty($val)) {
                $str .= _json_to_table_recursive_helper($val);
            }
        } else {
            $str .= "<strong>$val</strong>";
        }
        $str .= "</td></tr>";
    }
    $str .= "</tbody></table>";

    return $str;
}

function json_to_table($jsonText = ''): string {
    $arr = json_decode($jsonText, true);
    $html = "";
    if ($arr && is_array($arr)) {
        $html .= _json_to_table_recursive_helper($arr);
    }
    return $html;
}
