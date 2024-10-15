<?php

use App\Storage\FileStorage;
use App\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class FileStorageTest extends TestCase
{
    private string $testFilePath;

    private StorageInterface $storage;

    protected function setUp(): void
    {
        $this->testFilePath = __DIR__ . '/../logs/test_data.json';

        $this->storage = new FileStorage($this->testFilePath);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    public function testStoreSuccess()
    {
        $data = [
            'source' => 'test_source',
            'payload' => [
                'email' => 'test@mail.com',
                'data' => 'sample data',
            ],
        ];

        $result = $this->storage->store($data);

        $this->assertTrue($result);

        $this->assertFileExists($this->testFilePath);
    }
}
