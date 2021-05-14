<?php

declare(strict_types=1);

namespace Compolomus\FSHelper;

use ZipArchive;

class ZipHelper
{
    /**
     * Return string with default name of archive
     *
     * @return string
     */
    public static function generateRandomNameOfArchive(): string
    {
        $suffix = '-Archive.zip';
        $str    = uniqid($suffix, true);

        return str_replace('.', '', substr($str, 12, -4)) . $suffix;
    }

    /**
     * Add files from directory to archive
     *
     * @param string      $directoryPath Absolute or relative path
     * @param null|string $name          Name of archive, if empty the will be generated
     *
     * @return string Name with path to file
     */
    public static function createArchiveFromDirectory(string $directoryPath, string $name = null): string
    {
        if (empty($name)) {
            $name = self::generateRandomNameOfArchive();
        }

        $zip = new ZipArchive();
        $zip->open($name, ZipArchive::CREATE);

        $fixer = new PathFixer($directoryPath);

        foreach (FSHelper::getDirectories($directoryPath) as $dir) {
            $zip->addEmptyDir($fixer->fix($dir->getPathname()));
        }

        foreach (FSHelper::getFiles($directoryPath) as $file) {
            $zip->addFile($file->getPathname(), $fixer->fix($file->getPathname()));
        }

        $zip->close();

        return $name;
    }
}
