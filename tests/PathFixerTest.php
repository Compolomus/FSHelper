<?php

declare(strict_types=1);

namespace Compolomus\FSHelper\Tests;

use Compolomus\FSHelper\Exceptions\PathNotFoundException;
use Compolomus\FSHelper\PathFixer;
use PHPUnit\Framework\TestCase;

class PathFixerTest extends TestCase
{
    private string $path = __DIR__ . '/demo';

    public function test__construct(): void
    {
        $object = new PathFixer($this->path);
        self::assertInstanceOf(PathFixer::class, $object);
    }

    public function test__construct_pathNotFoundException(): void
    {
        $this->expectException(PathNotFoundException::class);
        new PathFixer($this->path . '/path_not_found');
    }

    public function test_getPath(): void
    {
        $object = new PathFixer($this->path);
        $test   = $object->getPath();
        self::assertEquals($this->path, $test);
    }

    public function test_getTrimLength(): void
    {
        $object = new PathFixer($this->path);
        $test   = $object->getTrimLength();
        self::assertEquals(39, $test);
    }

    public function test_fix(): void
    {
        $object = new PathFixer($this->path);
        $test   = $object->fix($this->path . '/test');
        self::assertEquals('demo/test', $test);
    }
}
