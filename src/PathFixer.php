<?php

declare(strict_types=1);

namespace Compolomus\FSHelper;

use Compolomus\FSHelper\Exceptions\PathNotFoundException;

class PathFixer
{
    /**
     * Absolute or relative path
     */
    private string $path;

    /**
     * Amount of symbols which can be removed from provided path
     */
    private int $trimLength;

    /**
     * PathFixer constructor.
     * @throws PathNotFoundException
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->execute();
    }

    /**
     * Provided path processing
     *
     * @throws PathNotFoundException
     */
    private function execute(): void
    {
        // Get rale path from provided path (because it can be relative)
        $real = realpath($this->path);

        // Throw an exception if the path does not exist
        if (!$real) {
            throw new PathNotFoundException($this->path);
        }

        // Get directory name by provided real path
        $base = basename($real);

        // Calculate trimmed length between real path and directory only
        $this->trimLength = mb_strlen($real) - mb_strlen($base);
    }

    /**
     * Remove required amount of characters from start of provided path
     */
    public function fix(string $path): string
    {
        return mb_substr($path, $this->trimLength);
    }

    /**
     * Return path added via constructor
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Return amount of symbols which will be trimmed
     */
    public function getTrimLength(): int
    {
        return $this->trimLength;
    }
}
