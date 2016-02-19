<?php
/**
 * Netdirive loader
 */

$netdriveload = [
    '/config.php',
    '/vendor/autoload.php',
    '/vendor/google/api/src/Google/autoload.php'
];

foreach ($netdriveload as $item) {
    if (file_exists(__DIR__ . $item) && is_readable(__DIR__ . $item)) {
        include_once(__DIR__ . $item);
    }
}
