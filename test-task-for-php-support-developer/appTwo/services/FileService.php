<?php

/**
 * Class FileService
 */
class FileService
{
    /**Get data from file
     * @param string $file
     * @return bool|string
     */
    public static function getContentFromFile(string $file)
    {
        return file_get_contents($file) ?? false;
    }
}