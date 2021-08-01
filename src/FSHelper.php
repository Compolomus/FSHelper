<?php

declare(strict_types=1);

namespace Compolomus\FSHelper;

use CallbackFilterIterator;
use Compolomus\FSHelper\Exceptions\PathNotFoundException;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FSHelper
{
    /**
     * Return all object with information about all files and folder by provided path
     *
     * @param string $directoryPath Absolute or relative path
     * @throws PathNotFoundException
     */
    public static function getAll(string $directoryPath): RecursiveIteratorIterator
    {
        $directoryPathReal = realpath($directoryPath);

        // Throw an exception if the path does not exist
        if (!$directoryPathReal) {
            throw new PathNotFoundException($directoryPath);
        }

        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $directoryPathReal,
                FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );
    }

    /**
     * Return objects of all directories by provided path
     *
     * @param string $directoryPath Absolute or relative path
     * @throws PathNotFoundException
     */
    public static function getDirectories(string $directoryPath): CallbackFilterIterator
    {
        $all = self::getAll($directoryPath);

        return new CallbackFilterIterator($all, static fn($iterator) => $iterator->isDir());
    }

    /**
     * Return objects of all files by provided path
     *
     * @param string $directoryPath Absolute or relative path
     * @throws PathNotFoundException
     */
    public static function getFiles(string $directoryPath): CallbackFilterIterator
    {
        $all = self::getAll($directoryPath);

        return new CallbackFilterIterator($all, static fn($iterator) => $iterator->isFile());
    }

    /**
     * Get total size of all files by provided path (in bytes)
     *
     * @param string $directoryPath Absolute or relative path
     * @throws PathNotFoundException
     */
    public static function getFilesSize(string $directoryPath): int
    {
        $size = 0;
        foreach (self::getFiles($directoryPath) as $fileInfo) {
            $size += $fileInfo->getSize();
        }

        return $size;
    }

    /**
     * Return meta information about files and directories
     *
     * @param string $directoryPath Absolute or relative path
     * @return array<string, mixed>
     * @throws PathNotFoundException
     */
    public static function getInfoDirectory(string $directoryPath): array
    {
        return [
            'directories' => iterator_count(self::getDirectories($directoryPath)),
            'files'       => iterator_count(self::getFiles($directoryPath)),
            'size'        => self::getFilesSize($directoryPath),
        ];
    }
}
