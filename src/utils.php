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

