<?php

if (!function_exists('storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param string $path
     * @return string
     */
    function storage_path(string $path = ''): string
    {
        $basePath = BASE_PATH . '/storage';
        return $path ? $basePath . '/' . ltrim($path, '/') : $basePath;
    }
}
