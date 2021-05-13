<?php

declare(strict_types=1);

namespace Compolomus\FSHelper;

class PathFixer
{
    private string $path;

    private int $trimLength;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->execute();
    }

    private function execute(): void
    {
        $this->trimLength = strlen($real = realpath($this->path)) - strlen(basename($real));
    }

    public function fix(string $path): string
    {
        return substr($path, $this->trimLength);
    }
}
