<?php

namespace App\Storage;

class FileStorage implements StorageInterface
{
    public function __construct(
        private readonly string $filePath,
    )
    {
    }

    public function store(array $data): bool
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        return file_put_contents($this->filePath, $jsonData, LOCK_EX) !== false;
    }
}
