<?php

namespace Commission\Helpers;

class FileSystem
{
    public function __construct(private string $basePath) {}

    public function getStoragePath(string $path = ''): string
    {
        $baseStoragePath = $this->basePath . '/storage';

        return $path ? $baseStoragePath . '/' . ltrim($path, '/') : $baseStoragePath;
    }
}