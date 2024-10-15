<?php

use App\Services\DataProcessor;
use PHPUnit\Framework\TestCase;

class DataProcessorTest extends TestCase
{
    public function testSanitizeWithEmail()
    {
        $payload = [
            'email' => 'mailto:test@example.com',
            'data' => 'sample data'
        ];

        $expected = [
            'email' => '_SENSITIVE_DATA_REMOVED_',
            'data' => 'sample data'
        ];

        $result = DataProcessor::sanitize($payload);

        $this->assertEquals($expected, $result);
    }

    public function testIsValidWithValidData()
    {
        $data = [
            'source' => 'test_source',
            'payload' => [
                'data' => 'sample data',
            ]
        ];

        $this->assertTrue(DataProcessor::isValid($data));
    }

    public function testIsValidWithEmptySource()
    {
        $data = [
            'source' => '',
            'payload' => [
                'data' => 'sample data',
            ]
        ];

        $this->assertFalse(DataProcessor::isValid($data));
    }

    public function testIsValidWithNonArrayPayload()
    {
        $data = [
            'source' => 'test_source',
            'payload' => 'not an array',
        ];

        $this->assertFalse(DataProcessor::isValid($data));
    }

    public function testIsValidWithEmptyPayload()
    {
        $data = [
            'source' => 'test_source',
            'payload' => [],
        ];

        $this->assertFalse(DataProcessor::isValid($data));
    }
}
