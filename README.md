# Compolomus FileSystem Helper

[![License](https://poser.pugx.org/compolomus/FSHelper/license)](https://packagist.org/packages/compolomus/fs-helper)

[![Build Status](https://scrutinizer-ci.com/g/Compolomus/FSHelper/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/FSHelper/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/FSHelper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/FSHelper/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Compolomus/FSHelper/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/FSHelper/?branch=master)
[![Code Climate](https://codeclimate.com/github/Compolomus/FSHelper/badges/gpa.svg)](https://codeclimate.com/github/Compolomus/FSHelper)
[![Downloads](https://poser.pugx.org/compolomus/FSHelper/downloads)](https://packagist.org/packages/compolomus/fs-helper)

## Install

```shell
composer require compolomus/fs-helper
```

## Usage

```php
use Compolomus\FSHelper\FSHelper;
use Compolomus\FSHelper\ZipHelper;

$dir = '../';

echo '<pre>' . print_r(FSHelper::getInfoDirectory($dir), true) . '</pre>';

ZipHelper::createArchiveFromDirectory($dir);
```

## Testing

You just need to run following command:

```shell
./vendor/bin/phpunit
```
