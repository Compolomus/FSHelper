<?php

declare(strict_types=1);

namespace Compolomus\FSHelper\Tests;

use Compolomus\FSHelper\Exceptions\PathNotFoundException;
use Compolomus\FSHelper\FSHelper;
use PHPUnit\Framework\TestCase;
use RecursiveIteratorIterator;

class FSHelperTest extends TestCase
{
    private string $path = __DIR__ . '/demo';

    public function test_getAll(): void
    {
        $test = FSHelper::getAll($this->path);
        self::assertInstanceOf(RecursiveIteratorIterator::class, $test);
    }

    public function test_getAll_pathNotFoundException(): void
    {
        $this->expectException(PathNotFoundException::class);
        FSHelper::getAll('/tmp/path_not_found');
    }

    public function test_getDirectories(): void
    {
        $dirs = FSHelper::getDirectories($this->path);
        $test = iterator_count($dirs);

        self::assertEquals(1, $test);
    }

    public function test_getFiles(): void
    {
        $files = FSHelper::getFiles($this->path);
        $test  = iterator_count($files);

        self::assertEquals(3, $test);
    }

    public function test_getFileSizes(): void
    {
        $test = FSHelper::getFilesSize($this->path);
        self::assertEquals(63, $test);
    }


    public function test_getInfoDirectory(): void
    {
        $demo = ['directories' => 1, 'files' => 3, 'size' => 63];
        $test = FSHelper::getInfoDirectory($this->path);

        self::assertArrayHasKey('directories', $test);
        self::assertArrayHasKey('files', $test);
        self::assertArrayHasKey('size', $test);

        self::assertEquals($demo, $test);
    }
}
