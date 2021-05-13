<?php

use Compolomus\FSHelper\FSHelper;

require_once __DIR__ . '/../vendor/autoload.php';

$dir = '../';

echo '<pre>' . print_r(FSHelper::getInfoDirectory($dir), true) . '</pre>';

FSHelper::addDirectoryToZipArchive($dir);
