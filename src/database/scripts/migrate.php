<?php
//require __DIR__ . "/hash.php";
require __DIR__ . "/../migrations/2022_01_15_1642257948_create_user_table.php";

$UP = "up";
$DOWN = "down";

$options = getopt("d:", array("direction:"));

if (!$options || !$options["d"]) {
    throw new ErrorException("`direction` argument cannot be empty");
}

$direction = $options["d"];
$migrations_files = array_diff(scandir((__DIR__ . "/../migrations")), ['..', '.']);

switch ($direction):
    case $UP:
        foreach ($migrations_files as $migration_file) {
            $migration_file_path = __DIR__ . "/../migrations" . "/" . $migration_file;
            $class = getClass($migration_file);

            $created = $class->up();
            if (!$created) {
                echo "There was an error with migration: " . $migration_file;
                throw new ErrorException("Migration error" . $migration_file);
            }

            echo "Migration UP" . $migration_file . " was successful";
        }
        break;
    case $DOWN:
        foreach ($migrations_files as $migration_file) {
            $migration_file_path = __DIR__ . "/../migrations" . "/" . $migration_file;
            $class = getClass($migration_file);

            $created = $class->down();
            if (!$created) {
                echo "There was an error with migration: " . $migration_file;
                throw new ErrorException("Migration error" . $migration_file);
            }

            echo "Migration DOWN " . $migration_file . " was successful";
        }
        break;
    default:
        throw new ErrorException("Unsupported argument value");
endswitch;


/**
 * @param $migration_file
 * @return mixed
 */
function getClass($migration_file) {
    $file1 = preg_replace('/[0-9]/', '', $migration_file);
    $file2 = explode("_", $file1);
    $file3 = implode(" ", $file2);
    $file4 = ucwords($file3);
    $file5 = str_replace(" ", "", $file4);
    $file6 = str_replace("php", "", $file5);
    $file7 = str_replace(".", "", $file6);
    $class_name = $file7;

    return new $class_name;
}
