<?php

declare(strict_types=1);

namespace Compolomus\FSHelper;

use CallbackFilterIterator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class FSHelper
{
    private static function getAll(string $directoryPath): RecursiveIteratorIterator
    {
        $directoryPath = realpath($directoryPath);

        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $directoryPath,
                FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );
    }

    private static function getDirectories(string $directoryPath): CallbackFilterIterator
    {
        $all = self::getAll($directoryPath);

        return new CallbackFilterIterator($all, static fn($iterator) => $iterator->isDir());
    }

    private static function getFiles(string $directoryPath): CallbackFilterIterator
    {
        $all = self::getAll($directoryPath);

        return new CallbackFilterIterator($all, static fn($iterator) => $iterator->isFile());
    }

    private static function getFileSizes(string $directoryPath): int
    {
        $size = 0;
        foreach (self::getFiles($directoryPath) as $fileInfo) {
            $size += $fileInfo->getSize();
        }

        return $size;
    }

    public static function getInfoDirectory(string $directoryPath): array
    {
        return [
            'directories' => iterator_count(self::getDirectories($directoryPath)),
            'files' => iterator_count(self::getFiles($directoryPath)),
            'size' => self::getFileSizes($directoryPath)
        ];
    }

    public static function addDirectoryToZipArchive(string $directoryPath, string $name = null): void
    {
        if (is_null($name)) {
            $str = uniqid($prefix = '-Archive.zip', true);
            $name = str_replace('.', '', substr($str, 12, -4)) . $prefix;
        }

        $zip = new ZipArchive();
        $zip->open($name, ZipArchive::CREATE);

        $fixer = new PathFixer($directoryPath);

        foreach (self::getDirectories($directoryPath) as $dir) {
            $zip->addEmptyDir($fixer->fix($dir->getPathname()));
        }
        foreach (self::getFiles($directoryPath) as $file) {
            $zip->addFile($file->getPathname(), $fixer->fix($file->getPathname()));
        }

        $zip->close();
    }
}
