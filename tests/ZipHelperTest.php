<?php

declare(strict_types=1);

namespace Compolomus\FSHelper\Tests;

use Compolomus\FSHelper\ZipHelper;
use FilesystemIterator;
use GlobIterator;
use PHPUnit\Framework\TestCase;

class ZipHelperTest extends TestCase
{
    private string $path = __DIR__ . '/demo';

    public function test_generateRandomNameOfArchive(): void
    {
        $suffix = '-Archive.zip';
        $test   = ZipHelper::generateRandomNameOfArchive();

        self::assertStringContainsString($suffix, $test);
    }

    public function test_createArchiveFromDirectory_generated(): void
    {
        $filename = ZipHelper::createArchiveFromDirectory($this->path);

        self::assertFileExists($filename);
    }

    public function test_createArchiveFromDirectory_withName(): void
    {
        $filename = ZipHelper::createArchiveFromDirectory($this->path, 'test-Archive.zip');

        self::assertFileExists($filename);
    }

    public static function tearDownAfterClass(): void
    {
        $iterator = new GlobIterator('*.zip', FilesystemIterator::KEY_AS_FILENAME);
        iterator_apply($iterator, static fn () => unlink($iterator->getRealPath()), [$iterator]);
    }
}
