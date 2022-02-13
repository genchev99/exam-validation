<?php

foreach (glob(__DIR__ . "/../seeders/*.php") as $filename) {
    include $filename;
}

$seeders_files = array_diff(scandir((__DIR__ . "/../seeders")), ['..', '.']);

foreach ($seeders_files as $seeder_file) {
    $seeder_file_path = __DIR__ . "/../seeders" . "/" . $seeder_file;
    $class = getClass($seeder_file);

    $created = $class->seed();
    if (!$created) {
        echo "There was an error with seed: " . $seeder_file . PHP_EOL;
        throw new ErrorException("Seed error" . $seeder_file);
    }

    echo "Seeded " . $seeder_file . PHP_EOL;
}


/**
 * @param $seeder_file
 * @return mixed
 */
function getClass($seeder_file)
{
    $file1 = preg_replace('/[0-9]/', '', $seeder_file);
    $file2 = explode("_", $file1);
    $file3 = implode(" ", $file2);
    $file4 = ucwords($file3);
    $file5 = str_replace(" ", "", $file4);
    $file6 = str_replace("php", "", $file5);
    $file7 = str_replace(".", "", $file6);
    $class_name = $file7;

    return new $class_name;
}
