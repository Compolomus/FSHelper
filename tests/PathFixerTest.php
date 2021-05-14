<?php

declare(strict_types=1);

namespace Compolomus\FSHelper\Tests;

use Compolomus\FSHelper\Exceptions\PathNotFoundException;
use Compolomus\FSHelper\PathFixer;
use PHPUnit\Framework\TestCase;

class PathFixerTest extends TestCase
{
    public function test__construct(): void
    {
        $object = new PathFixer('/tmp');
        self::assertInstanceOf(PathFixer::class, $object);
    }

    public function test__construct_pathNotFoundException(): void
    {
        $this->expectException(PathNotFoundException::class);
        new PathFixer('/tmp/path_not_found');
    }

    public function test_getPath(): void
    {
        $object = new PathFixer('/tmp');
        $test   = $object->getPath();
        self::assertEquals('/tmp', $test);
    }

    public function test_getTrimLength(): void
    {
        $object = new PathFixer('/tmp');
        $test   = $object->getTrimLength();
        self::assertEquals(1, $test);
    }

    public function test_fix(): void
    {
        $object = new PathFixer('/tmp');
        $test   = $object->fix('/tmp/test');
        self::assertEquals('tmp/test', $test);
    }
}
