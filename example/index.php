<?php

use Compolomus\FSHelper\FSHelper;
use Compolomus\FSHelper\ZipHelper;

require_once __DIR__ . '/../vendor/autoload.php';

$dir = '../';

echo '<pre>' . print_r(FSHelper::getInfoDirectory($dir), true) . '</pre>';

ZipHelper::createArchiveFromDirectory($dir);
